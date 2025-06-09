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
$appointmentId = $_GET['appointment_id'] ?? null;

switch ($action) {

    case 'editAppointmentSubmit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'appointment_id' => $_POST['appointment_id'] ?? null,
                'appointment_date' => $_POST['appointment_date'] ?? '',
                'ailment' => $_POST['ailment'] ?? '',
                'medical_history' => $_POST['medical_history'] ?? '',
                'current_medication' => $_POST['current_medication'] ?? ''
            ];

            $editResult = $patientController->editAppointment($data);

            if (!$editResult->success) {
                $_SESSION['error'] = $editResult->message;
                header("Location: index.php?action=viewAllAppointments");
                exit;
            }

            $_SESSION['success'] = $editResult->message;
            header("Location: index.php?action=viewAllAppointments");
            exit;
        }
        break;

    case 'updateStatus':
        $appointmentId = $_POST['appointment_id'] ?? null;
        //User can not cancel denied appolintments work on that
        if ($appointmentId) {
            $response = $appointmentController->updateAppointment($appointmentId, 'cancelled');
            if (!$response) {
                $_SESSION['error'] = 'Cancelling Appointment failed';
            }
            header('Location: index.php?action=viewAllAppointments');
            exit;
        }
        break;


    case 'viewAllAppointments':
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;


        $patientId = $_SESSION['user']['user_id'];
        $appointments = $patientController->getAppointments($patientId, $status, $search);
        $statistics = $patientController->getUserStatistics($patientId);
        include __DIR__ . '/views/patientDashboard.php';

        break;

    case 'createAppointment':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                "patient_id" => (int) ($_POST['patient_id'] ?? 0),
                "appointment_date" => !empty($_POST['appointment_date']) ? $_POST['appointment_date'] : null,
                 "ailment" => $_POST['ailment'] ?? '',
                "medical_history" => $_POST['medical_history'] ?? 'N/A',
                "current_medication" => $_POST['current_medication'] ?? 'N/A',
            ];

            $response = $patientController->createAppointment($data);

            if($response->success) {
                $_SESSION['message'] = $response->message;
                header('Location: index.php?action=viewAllAppointments');
            }
            else {
                $_SESSION['error'] = $response->message;
                $_SESSION['old'] = $data;
                header('Location: index.php?action=viewAllAppointments');
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

                else header('Location: index.php?action=viewAllAppointments');
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
        header("Location: views/patientDashboard.php");
        break;

    default:
        include __DIR__ . '/views/patientDashboard.php';
        break;
}


