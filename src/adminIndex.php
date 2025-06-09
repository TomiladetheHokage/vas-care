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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? '';

            // Only doctors get availability; nurses don't
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

            // Call your controller to add staff member
            $response = $adminController->addStaffMember($data, $role);

            if ($response->success) {
                $_SESSION['message'] = $response->message;
                unset($_SESSION['docRegError'], $_SESSION['error'], $_SESSION['old']);
            } else {
                // Store errors and old input depending on role
                if ($role === 'doctor') {
                    $_SESSION['docRegError'] = $response->message;
                } elseif ($role === 'nurse') {
                    $_SESSION['error'] = $response->message;
                }
                $_SESSION['old'] = $data;
            }

            // Redirect back to the users view page
            header('Location: /vas-care/src/adminIndex.php?action=viewAllUsers');
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
        header("Location: views/patientDashboard.php");
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

        // Fetch next page users
        $nextPageResponse = $adminController->getPaginatedUsers($filters, $page + 1, $limit);
        $nextPageUsers = $nextPageResponse['users'];

        include __DIR__ . '/views/adminDashboard.php';
        break;


    case 'index':
    default:
        $users = [];
        break;
}
