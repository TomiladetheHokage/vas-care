<?php

use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\NurseController;
use Owner\VasCare\controller\AppointmentController;

session_start();


require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controller/NurseController.php';
require_once __DIR__ . '/controller/AppointmentController.php';
require_once __DIR__ . '/controller/DoctorController.php';
require_once __DIR__ . '/dto/response/StatusResponse.php';


$conn = getConnection();
$nurse = new NurseController($conn);
$appointment = new AppointmentController($conn);
$doctor = new DoctorController($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'updateStatus':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointment_id = $_POST['appointment_id'];
            $status = $_POST['status'];

            $response = $appointment->updateAppointment($appointment_id, $status);

            if($response) {
                $_SESSION['message'] = 'Updated successfully';
                header('Location: /vas-care/src/nurseIndex.php?action=viewAllAppointments');
            }
            else{
                $_SESSION['AssignError'] = 'Update failed because appointment has already been assigned';
                header('Location: /vas-care/src/nurseIndex.php?action=viewAllAppointments');
            }
            exit();
        }
        break;


    case 'assignDoctor':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $doctor_id = $_POST['doctor_id'] ?? '';
            $nurse_id = $_POST['nurse_id'] ?? '';
            $appointment_id = $_POST['appointment_id'] ?? '';
            $response = $nurse->assignDoctor($doctor_id, $appointment_id, $nurse_id);

            if (!$response->success) {
                $_SESSION['AssignError'] = $response->message;
            }
            $_SESSION['selectedDoctorId'] = $doctor_id;
            header('Location: /vas-care/src/nurseIndex.php?action=viewAllAppointments');
            exit();
        }
        break;



    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $statistics = $nurse->getUserStatistics();

        $appointments = $appointment->getAppointments($status, $search);
        $_SESSION['error'] = $appointments['error'] ?? null;
        $doctors = $doctor->getAllDoctors();
        include __DIR__ . '/views/newNurseDashboard.php';
//        include __DIR__ . '/views/nurseDashboard.php';
        break;



}