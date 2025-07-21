<?php
session_start();

use Owner\VasCare\controller\AdminController;
use Owner\VasCare\controller\AppointmentController;
use Owner\VasCare\controller\DoctorController;
use Owner\VasCare\controller\PatientController;
use Owner\VasCare\controller\UserController;

require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/config/constants.php';

require_once __DIR__ . '/../src/controller/AdminController.php';


$adminController = new AdminController(getConnection());


$action = $_GET['action'] ?? 'viewAllUsers';

switch ($action) {
    case 'dashboard':
        include __DIR__ . '/../src/views/adminDashboard.php';
        break;
    case 'registerDoctor':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $adminController->registerDoctor($_POST);
            if (!$response->success) {
                $_SESSION['docRegError'] = $response->message;
                $_SESSION['old'] = $_POST;
            } else {
                $_SESSION['message'] = $response->message;
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

        include __DIR__ . '/../src/views/adminDashboard.php';
        break;

}
