<?php
session_start();
use Owner\VasCare\controller\AppointmentController;
use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\NurseController;

require_once __DIR__ . '/../src/model/AppointmentModel.php';
require_once __DIR__ . '/../src/controller/AppointmentController.php';
require_once __DIR__ . '/../src/controller/DoctorController.php';
require_once __DIR__ . '/../src/controller/NurseController.php';
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/config/constants.php';

$db = getConnection();

$appointment = new AppointmentController($db);
$doctor = new DoctorController($db);
$nurse = new NurseController($db);

$action = $_GET['action'] ?? 'viewAllAppointments';
$appointmentId = $_GET['appointment_id'] ?? null;
$status = $_GET['status'] ?? null;

switch ($action) {

    case 'updateStatus':
        $appointmentId = $_POST['appointment_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $comment = $_POST['comment'] ?? null;

        if ($appointmentId && $status) {
            $response = $appointment->updateAppointmentStatus($appointmentId, $status, $comment);

            if (!$response->success) {
                $_SESSION['error'] = $response->message;
            } else {
                $_SESSION['success'] = $response->message;
            }
        } else {
            $_SESSION['error'] = 'Invalid request. Missing appointment ID or status.';
        }
        header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
        exit;

    case 'assignDoctor':
        $appointmentId = $_POST['appointment_id'] ?? null;
        $doctorId = $_POST['doctor_id'] ?? null;
        $nurseId = $_POST['nurse_id'] ?? null;

        if ($appointmentId && $doctorId && $nurseId) {
            $response = $nurse->assignDoctorToAppointment($appointmentId, $doctorId, $nurseId);

            if (!$response->success) {
                $_SESSION['AssignError'] = $response->message;
            }
        } else {
            $_SESSION['AssignError'] = 'Invalid data provided for assignment.';
        }
        header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
        exit;


    case 'assignTimeSlot':
        $appointmentId = $_POST['appointment_id'] ?? null;
        $slotStart = $_POST['slot_start'] ?? null;
        $slotEnd = $_POST['slot_end'] ?? null;
        $appointmentDate = $_POST['appointment_date'] ?? null;

        if ($appointmentId && $slotStart && $slotEnd) {
            $response = $nurse->assignTimeSlot($appointmentId, $slotStart, $slotEnd, $appointmentDate);

            if (!$response->success) {
                $_SESSION['error'] = $response->message;
            } else {
                $_SESSION['success'] = $response->message;
            }

        } else {
            $_SESSION['error'] = 'Invalid data for assigning time slot.';
        }

        header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
        exit;


    case 'editTimeSlot':
        $appointmentId = $_POST['appointment_id'] ?? null;
        $slotStart = $_POST['slot_start'] ?? null;
        $slotEnd = $_POST['slot_end'] ?? null;
        $appointmentDate = $_POST['appointment_date'] ?? null;

        if ($appointmentId && $slotStart && $slotEnd) {
            $response = $nurse->assignTimeSlot($appointmentId, $slotStart, $slotEnd, $appointmentDate);

            if (!$response->success) {
                $_SESSION['error'] = $response->message;
            } else {
                $_SESSION['success'] = $response->message;
            }
        } else {
            $_SESSION['error'] = 'Invalid data for editing time slot.';
        }

        header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
        exit;


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

        include __DIR__ . '/../src/views/nursedasboard2.php';
        break;

    default:
        header('Location: ' . BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
        exit();
}
