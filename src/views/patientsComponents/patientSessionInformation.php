<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;

$firstName = $isLoggedIn ? htmlspecialchars($user['first_name']) : '';
$email = $isLoggedIn ? htmlspecialchars($user['email']) : '';
$role = $isLoggedIn ? htmlspecialchars($user['role']) : '';
$profile_picture = !empty($user['profile_picture']) ? $user['profile_picture'] : '/vas-care/src/assets/3.jpg';
$error = $_SESSION['error'] ?? null;

if ($role !== 'patient') {
    include __DIR__ . '/../components/landingPage.php';
    exit();
}


if (!$isLoggedIn) {
    include 'components/landingPage.php';
    exit;
}
?>