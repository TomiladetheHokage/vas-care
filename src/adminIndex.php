<?php
session_start();

require_once __DIR__ . '/config/constants.php';

// Require dependencies
require_once __DIR__ . '/controller/AdminController.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/dto/response/RegisterResponse.php';

use Owner\VasCare\controller\AdminController;

$conn = getConnection();
$adminController = new AdminController($conn);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'createNewStaffMember':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? '';

            $availability = ($role === 'doctor') ? ($_POST['availability'] ?? null) : null;

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

            if ($response->success) {
                $_SESSION['message'] = $response->message;
                unset($_SESSION['docRegError'], $_SESSION['error'], $_SESSION['old']);
            } else {
                if ($role === 'doctor') {
                    $_SESSION['docRegError'] = $response->message;
                } elseif ($role === 'nurse') {
                    $_SESSION['error'] = $response->message;
                }
                $_SESSION['old'] = $data;
            }

            header('Location: ' . BASE_URL . '/adminIndex.php?action=viewAllUsers');
            exit();
        }
        break;

    case 'updateUserStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($userId !== null && $status !== null) {
                $updatedStatus = $adminController->updateUserStatus($userId, $status);
                if ($updatedStatus->success) {
                    header('Location: ' . BASE_URL . '/adminIndex.php?action=viewAllUsers');
                    exit();
                }
            }
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: ' . BASE_URL . '/views/components/landingPage.php');
        exit();
        break;

    case 'viewAllUsers':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 50;

        $filters = [
            'search' => $_GET['search'] ?? null,
            'role' => $_GET['role'] ?? null,
            'status' => $_GET['status'] ?? null,
        ];

        $statistics = $adminController->getUserStatistics();

        $response = $adminController->getPaginatedUsers($filters, $page, $limit);
        $users = $response['users'];
        $total = $response['total'];
        $totalPages = ceil($total / $limit);

        $nextPageResponse = $adminController->getPaginatedUsers($filters, $page + 1, $limit);
        $nextPageUsers = $nextPageResponse['users'] ?? [];

        include __DIR__ . '/views/adminDashboard.php';
        break;

//    case 'index':
//    default:
//        header('Location: ' . BASE_URL . '/adminIndex.php?action=viewAllUsers');
//        exit();
//        break;
}
