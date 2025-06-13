<?php

use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\NurseController;
use Owner\VasCare\controller\AppointmentController;

session_start();


require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';
//require_once __DIR__ . '/controller/NurseController.php';
//require_once __DIR__ . '/controller/AppointmentController.php';
require_once __DIR__ . '/controller/DoctorController.php';
require_once __DIR__ . '/dto/response/StatusResponse.php';


$conn = getConnection();
//$nurse = new NurseController($conn);
//$appointment = new AppointmentController($conn);
$doctor = new DoctorController($conn);

$action = $_GET['action'] ?? 'index';
//$_SESSION['doctor'] = $doctor->getDoctorByUserId($_SESSION['user']['user_id']);
//print_r($_SESSION['doctor']['availability']);
function redirect($url) {
    header("Location: $url");
    exit;
}

$doctorId = $_SESSION['user']['user_id'] ?? 0;
$availability = $_POST['availability'] ?? '';


switch ($action) {

    case 'logout':
        session_destroy();
        redirect("views/patientDashboard.php");
        break;

    case 'updateDoctorStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctorId = $_SESSION['user']['user_id'] ?? null;
            $availability = $_POST['availability'] ?? '';
            $response = $doctor->updateAvailability($doctorId, $availability);

            if ($response) {
                $_SESSION['message'] = "Doctor availability updated successfully";
                $_SESSION['doctor'] = $doctor->getDoctorByUserId($doctorId);
            } else {
                $_SESSION['error'] = "Failed to update doctor availability.";
            }

            header('Location: ' . BASE_URL . '/doctorIndex.php?action=viewAllAppointments');
            exit;
        }
        break;



    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $statistics = $doctor->getAppointmentCount($doctorId);

        $appointments = $doctor->getAssignedAppointments($doctorId);
        $appointmentCount = count($appointments);

        $_SESSION['error'] = $appointments['error'] ?? null;
        $doctors = $doctor->getAllDoctors();
        include __DIR__ . '/views/doctorDashboard.php';
        break;
}