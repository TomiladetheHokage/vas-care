<?php
session_start();

use Owner\VasCare\controller\UserController;

// ========== Include dependencies ==========
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/config/constants.php';

require_once __DIR__ . '/../src/controller/AppointmentController.php';
require_once __DIR__ . '/../src/controller/PatientController.php';
require_once __DIR__ . '/../src/controller/UserController.php';
require_once __DIR__ . '/../src/controller/DoctorController.php';

require_once __DIR__ . '/../src/dto/response/AppointmentResponse.php';
require_once __DIR__ . '/../src/dto/response/RegisterResponse.php';
require_once __DIR__ . '/../src/dto/response/LoginResponse.php';

// ========== Setup ==========
$conn = getConnection();

// ========== Handle actions ==========
$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'dashboard':
        include __DIR__ . '/../src/views/dashboards/patient_dashboard.php';
        break;

    case 'viewAllAppointments':
        $patientId = $_SESSION['user']['user_id'] ?? null;

        $appointments = $patientController->getAppointments($patientId, $status, $search);
        $statistics = $patientController->getUserStatistics($patientId);
        include __DIR__ . '/../src/views/dashboards/patient_dashboard.php';
        break;

    case 'createAppointment':
        include __DIR__ . '/../src/views/create_appointment.php';
        break;

    case 'saveAppointment':
        $data = [
            'patient_id' => $_SESSION['user']['user_id'],
            'doctor_id' => $_POST['doctor_id'],
            'appointment_date' => $_POST['appointment_date'],
            'appointment_time' => $_POST['appointment_time'],
            'status' => 'pending',
            'notes' => $_POST['notes'] ?? null,
        ];

        $response = $appointmentController->createAppointment($data);

        if ($response->success) {
            redirect(BASE_URL . '/index.php?action=viewAllAppointments');
        } else {
            $_SESSION['error'] = $response->message;
            $_SESSION['old'] = $data;
            redirect("index.php?action=createAppointment");
        }
        break;

    case 'register':
        include __DIR__ . '/../src/views/register.php';
        break;

    case 'saveRegister':
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role' => 'patient',
        ];

        $response = $userController->register($data);

        if ($response->success) {
            redirect(BASE_URL . '/index.php?action=login');
        } else {
            $_SESSION['error'] = $response->message;
            $_SESSION['old'] = $data;
            redirect("index.php?action=register");
        }
        break;

    case 'login':
        include __DIR__ . '/../src/views/login.php';
        break;

    case 'handleLogin':
        $email = $_POST['email'];
        $password = $_POST['password'];

        $response = $userController->login($email, $password);

        if ($response->success) {
            $_SESSION['user'] = $response->data;
            if ($response->data['role'] === 'patient') {
                redirect(BASE_URL . '/index.php?action=dashboard');
            } else {
                redirect(BASE_URL . '/index.php?action=dashboard');
            }
        } else {
            $_SESSION['old'] = ['email' => $email];
            $_SESSION['error'] = $response->message;
            redirect('index.php?action=login');
        }
        break;

    case 'logout':
        session_destroy();
        redirect(BASE_URL . '/index.php?action=login');
        break;

    default:
        include __DIR__ . '/../src/views/dashboards/patient_dashboard.php';
        break;
}
