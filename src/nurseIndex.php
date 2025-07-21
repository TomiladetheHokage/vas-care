<?php

use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\NurseController;
use Owner\VasCare\controller\AppointmentController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//// BASE URL setup
//$host = $_SERVER['HTTP_HOST'];
//$port = $_SERVER['SERVER_PORT'];
//
//if (str_contains($host, 'onrender.com')) {
//    define('BASE_URL', '');
//} elseif ($port == 8000) {
//    define('BASE_URL', '');
//} else {
//    define('BASE_URL', '/vas-care/src');
//}

// Require necessary files
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';
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

    case 'editTimeSlot':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'];
            $appointment_date = $_POST['appointment_date'] ?? null;
            $slotStart = $_POST['slot_start'];
            $slotEnd = $_POST['slot_end'];

            $response = $nurse->editTimeSlot($appointment_id, $appointment_date, $slotStart, $slotEnd);

            $_SESSION[$response->success ? 'message' : 'AssignError'] = $response->message;

            header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
            exit();
        }
        break;

    case 'assignTimeSlot':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'];
            $appointment_date = $_POST['appointment_date'] ?? null;
            $slotStart = $_POST['slot_start'];
            $slotEnd = $_POST['slot_end'];

            $response = $nurse->assigntimeToAppointment($appointment_id, $appointment_date, $slotStart, $slotEnd);

            $_SESSION[$response->success ? 'message' : 'AssignError'] = $response->message;

            header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
            exit();
        }
        break;

    case 'updateStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'] ?? null;
            $status = 'denied';
            $comment = $_POST['comment'] ?? null;

            $response = $appointment->updateAppointmentStatus($appointment_id, $status, $comment);

            $_SESSION[$response->success ? 'message' : 'AssignError'] = $response->message;

            header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
            exit();
        }
        break;


    case 'assignDoctor':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctor_id = $_POST['doctor_id'] ?? '';
            $nurse_id = $_POST['nurse_id'] ?? '';
            $appointment_id = $_POST['appointment_id'] ?? '';

            $response = $nurse->assignDoctor($doctor_id, $appointment_id, $nurse_id);

            if (!$response->success) {
                $_SESSION['AssignError'] = $response->message;
            }

            $_SESSION['selectedDoctorId'] = $doctor_id;

            header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
            exit();
        }
        break;

    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 15;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $totalAppointments = $appointment->appointmentModel->countAppointments($status, $search);
        $totalPages = ceil($totalAppointments / $limit);

        $appointments = $appointment->getAppointments($status, $search, $limit, $offset);
        $statistics = $nurse->getUserStatistics();
        $doctors = $doctor->getAllDoctors();
        $currentPage = $page;

        include __DIR__ . '/views/nursedasboard2.php';
        break;

    default:
        // You can redirect to a default view or page here
        header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
        exit();
}
