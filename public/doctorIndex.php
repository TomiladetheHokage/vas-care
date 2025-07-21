<?php

use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\NurseController;
use Owner\VasCare\controller\AppointmentController;

session_start();


require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/config/constants.php';
require_once __DIR__ . '/../src/controller/DoctorController.php';
require_once __DIR__ . '/../src/controller/AppointmentController.php';
require_once __DIR__ . '/../src/dto/response/StatusResponse.php';


$conn = getConnection();
$doctorController = new DoctorController($conn);
$appointmentController = new AppointmentController($conn);

$action = $_GET['action'] ?? 'viewAllAppointments';
$doctorId = $_SESSION['user']['user_id'] ?? null;

function redirect($url) {
    header("Location: $url");
    exit;
}

switch ($action) {
    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $response = $doctorController->getDoctorAppointments($doctorId, $status, $search, $limit, $offset);

        $totalAppointments = $response['total'];
        $totalPages = ceil($totalAppointments / $limit);

        $appointments = $response['appointments'];
        $statistics = $doctorController->getDoctorStatistics($doctorId);

        include __DIR__ . '/../src/views/dashboards/doctor_dashboard.php';
        break;

    case 'updateAvailability':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $availability = $_POST['availability'] ?? null;
            $response = $doctorController->updateAvailability($doctorId, $availability);

            if ($response->success) {
                $_SESSION['doctor']['availability'] = $availability;
                $_SESSION['message'] = "Availability updated successfully.";
            } else {
                $_SESSION['error'] = "Failed to update availability.";
            }
            header('Location: ' . BASE_URL . '/doctorIndex.php?action=viewAllAppointments');
            exit();
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: ' . BASE_URL . '/views/login.php');
        exit();
        break;

    default:
        header('Location: ' . BASE_URL . '/doctorIndex.php?action=viewAllAppointments');
        exit();
}