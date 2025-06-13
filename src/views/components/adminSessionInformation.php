<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../config/constants.php';


$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

if ($user['role'] !== 'admin') {
    header('Location: ' . BASE_URL . '/views/patientDashboard.php');
    exit();
}

$firstName = $isLoggedIn ? $user['first_name'] : '';
$email = $isLoggedIn ? $user['email'] : '';
$pfp = $isLoggedIn && isset($user['profile_picture']) ? $user['profile_picture'] : BASE_URL . '/assets/3.jpg';

$old = $_SESSION['old'] ?? [];
$error = $_SESSION['error'] ?? '';
$docRegError = $_SESSION['docRegError'] ?? '';
unset($_SESSION['old'], $_SESSION['error'], $_SESSION['docRegError']);
?>