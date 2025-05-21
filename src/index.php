<?php
session_start();

use Owner\VasCare\controller\AppointmentController;
use Owner\VasCare\controller\PatientController;
use Owner\VasCare\controller\UserController;

require_once __DIR__ . '/controller/AppointmentController.php';
require_once __DIR__ . '/controller/UserController.php';
require_once __DIR__ . '/controller/PatientController.php';

require_once __DIR__ . '/dto/response/AppointmentResponse.php';
require_once __DIR__ . '/dto/response/RegisterResponse.php';
require_once __DIR__ . '/dto/response/LoginResponse.php';

require_once __DIR__ . '/config/database.php';

$conn = getConnection();

$userController = new UserController($conn);
$patientController = new PatientController($conn);
$appointmentController = new AppointmentController($conn);

$action = $_GET['action'] ?? 'index';
echo $action;

switch ($action) {
    case 'createAppointment':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                "patient_id" => (int) ($_POST['patient_id'] ?? 0),
                "appointment_date" => $_POST['appointment_date'] ?? '',
                 "slot_start" => $_POST['slot_start'] ?? '',
                 "slot_end" => $_POST['slot_end'] ?? '',
                 "ailment" => $_POST['ailment'] ?? '',
                "medical_history" => $_POST['medical_history'] ?? 'N/A',
                "current_medication" => $_POST['current_medication'] ?? 'N/A',
            ];

            $response = $patientController->createAppointment($data);

            if($response->success) {
                $_SESSION['message'] = $response->message;
                header('Location: views/dashboard.php');
            }
            else {
                $_SESSION['error'] = $response->message;
                $_SESSION['old'] = $data;
                header('Location: views/createAppointment.php');
            }
            exit;
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $response = $userController->login($email, $password);

            if ($response->success) {
                $_SESSION['user'] = $response->userData;
                $doctorId = $_SESSION['user']['user_id'] ?? 0;

                $role = $response->userData['role'] ?? '';

                if ($role === 'admin') header('location: /vas-care/src/adminIndex.php?action=viewAllUsers');

                else if ($role === 'nurse')header('location: /vas-care/src/nurseIndex.php?action=viewAllAppointments');

                else if ($role === 'doctor')header('location: /vas-care/src/doctorIndex.php?action=viewAllAppointments');

                else header('Location: views/dashboard.php');
            }
            else {
                $_SESSION['old'] = ['email' => $email];
                $_SESSION['error'] = $response->message;
                header('Location: views/login.php');
            }
            exit;
        }
        break;

    case 'register':
        require_once __DIR__ . '/views/register.php';
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
                'role' => "patient" ?? '',
                'address' => $_POST['address'] ?? '',
                'profile_picture' => $_POST['profile_picture'] ?? '',
            ];

            $response = $userController->register($data);

            if ($response->success) {
                header("Location: /vas-care/src/views/login.php");
            } else {
                $_SESSION['error'] = $response->message;
                $_SESSION['old'] = $data;
                header("Location: views/register.php");
            }
            exit;
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: views/login.php");
        break;

    default:
        include __DIR__ . '/views/register.php';
        break;
}


