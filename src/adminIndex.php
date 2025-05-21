<?php

use Owner\VasCare\controller\AdminController;

session_start();
require_once __DIR__ . '/controller/AdminController.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/dto/response/RegisterResponse.php';

$conn = getConnection();
$adminController = new AdminController($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'createNewStaffMember':
        $availability = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role = $_POST['role'];
            if($role == 'doctor'){
                $availability = $_POST['availability'];
            }
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'specialization' => $_POST['specialization'] ?? '',
                'availability' => $availability,
                'profile_picture' => $_FILES['profile_picture'] ?? null,
            ];

            $response = $adminController->addStaffMember($data, $role);
            if ($response->success) $_SESSION['message'] = $response->message;

            else{
                if($role === 'doctor')$_SESSION['docRegError'] = $response->message;
                if($role === 'nurse')$_SESSION['error'] = $response->message;
                $_SESSION['old'] = $data;
            }
            header('location: /vas-care/src/adminIndex.php?action=viewAllUsers');
            exit();
        }
        break;


    case 'updateUserStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $userId = $_POST['user_id'];
            $status = $_POST['status'];

            $updatedStatus = $adminController->updateUserStatus($userId, $status);
            if ($updatedStatus->success) {
                header('location: /vas-care/src/adminIndex.php?action=viewAllUsers');
            }
        }
        break;


    case 'logout':
        session_destroy();
        header("Location: views/login.php");
        break;


    case 'viewAllUsers':
        $stats = $adminController->getUserStatisticss();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filters = [
            'search' => $_GET['search'] ?? null,
            'role' => $_GET['role'] ?? null,
            'status' => $_GET['status'] ?? null,
        ];
        $response = $adminController->getPaginatedUsers($filters, $page, 50);
        $users = $response['users'];
        $total = $response['total'];
        $totalPages = ceil($total / 5);

        include __DIR__ . '/views/adminDashboard.php';
        break;



    case 'index':
    default:
        $users = [];
        break;
}
