<?php
session_start();

use Owner\VasCare\controller\AppointmentController;
use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\PatientController;
use Owner\VasCare\controller\UserController;

// ========== Include dependencies ==========
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';

require_once __DIR__ . '/controller/AppointmentController.php';
require_once __DIR__ . '/controller/PatientController.php';
require_once __DIR__ . '/controller/UserController.php';
require_once __DIR__ . '/controller/DoctorController.php';

require_once __DIR__ . '/dto/response/AppointmentResponse.php';
require_once __DIR__ . '/dto/response/RegisterResponse.php';
require_once __DIR__ . '/dto/response/LoginResponse.php';

// ========== Setup ==========
$conn = getConnection();
$userController = new UserController($conn);
$patientController = new PatientController($conn);
$appointmentController = new AppointmentController($conn);
$doctorController = new DoctorController($conn);

$action = $_GET['action'] ?? 'index';
$appointmentId = $_GET['appointment_id'] ?? null;

// ========== Helper: Redirect ==========
function redirect($url) {
    header("Location: $url");
    exit;
}

// ========== Router ==========
switch ($action) {

    case 'editAppointmentSubmit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'appointment_id' => $_POST['appointment_id'] ?? null,
                'requested_date' => $_POST['requested_date'] ?? '',
                'ailment' => $_POST['ailment'] ?? '',
                'medical_history' => $_POST['medical_history'] ?? '',
                'current_medication' => $_POST['current_medication'] ?? ''
            ];

            $result = $patientController->editAppointment($data);

            $_SESSION[$result->success ? 'success' : 'error'] = $result->message;
            redirect("index.php?action=viewAllAppointments");
        }
        break;

    case 'updateStatus':
        $appointmentId = $_POST['appointment_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $comment = $_POST['comment'] ?? null;

        if ($appointmentId && $status) {
            $response = $appointmentController->updateAppointmentStatus($appointmentId, $status, $comment);

            if (!$response->success) {
                $_SESSION['error'] = $response->message;
            } else {
                $_SESSION['success'] = $response->message;
            }

        } else {
            $_SESSION['error'] = 'Invalid request. Missing appointment ID or status.';
        }
        redirect('index.php?action=viewAllAppointments');
        break;


    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;
        $patientId = $_SESSION['user']['user_id'] ?? null;

        $appointments = $patientController->getAppointments($patientId, $status, $search);
        $statistics = $patientController->getUserStatistics($patientId);
//        include __DIR__ . '/views/patientDashboard.php';
        include __DIR__ . '/views/dashboards/patient_dashboard.php';
        break;

    case 'createAppointment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                "patient_id" => (int) ($_POST['patient_id'] ?? 0),
                "requested_date" => $_POST['requested_date'] ?? null,
                "ailment" => $_POST['ailment'] ?? '',
                "medical_history" => $_POST['medical_history'] ?? 'N/A',
                "current_medication" => $_POST['current_medication'] ?? 'N/A',
            ];

            $response = $patientController->createAppointment($data);
            $_SESSION[$response->success ? 'message' : 'error'] = $response->message;

            if (!$response->success) {
                $_SESSION['old'] = $data;
            }

            redirect('index.php?action=viewAllAppointments');
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $response = $userController->login($email, $password);

            if ($response->success) {
                $_SESSION['user'] = $response->userData;
                $_SESSION['doctor'] = $doctorController->getDoctorByUserId($_SESSION['user']['user_id']);
                $role = $response->userData['role'] ?? '';

                switch ($role) {
                    case 'admin':
                        redirect(BASE_URL . '/adminIndex.php?action=viewAllUsers');
                    case 'nurse':
                        redirect(BASE_URL . '/nurseIndex.php?action=viewAllAppointments');
                    case 'doctor':
                        redirect(BASE_URL . '/doctorIndex.php?action=viewAllAppointments');
                    default:
                        redirect('index.php?action=viewAllAppointments');
                }
            } else {
                $_SESSION['old'] = ['email' => $email];
                $_SESSION['error'] = $response->message;
                redirect('views/login.php');
            }
        }
        break;

    case 'register':
        include __DIR__ . '/views/register.php';
        break;

    case 'saveRegister':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone_number' => $_POST['phone_number'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'password' => $_POST['password'] ?? '',
                'role' => 'patient',
                'address' => $_POST['address'] ?? '',
                'profile_picture' => $_POST['profile_picture'] ?? '',
            ];

            $response = $userController->register($data);

            if ($response->success) {
                redirect(BASE_URL . '/views/login.php');
            } else {
                $_SESSION['error'] = $response->message;
                $_SESSION['old'] = $data;
                redirect("views/register.php");
            }
        }
        break;

    case 'logout':
        session_destroy();
        redirect("views/patientDashboard.php");
        break;

    default:
        include __DIR__ . '/views/patientDashboard.php';
        break;
}
