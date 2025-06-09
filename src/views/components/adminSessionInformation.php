<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

if ($user['role'] !== 'admin') {
    header('Location: /vas-care/src/views/patientDashboard.php');
    exit();
}

$firstName = $isLoggedIn ? $user['first_name'] : '';
$email = $isLoggedIn ? $user['email'] : '';
$pfp = $isLoggedIn && isset($user['profile_picture']) ? $user['profile_picture'] : '/vas-care/src/assets/3.jpg';

$old = $_SESSION['old'] ?? [];
$error = $_SESSION['error'] ?? '';
$docRegError = $_SESSION['docRegError'] ?? '';
unset($_SESSION['old'], $_SESSION['error'], $_SESSION['docRegError']);
?>