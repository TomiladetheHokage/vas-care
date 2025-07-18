<?php
require_once __DIR__ . '/../../config/constants.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? [];
$name = ($user['first_name'] ?? '');
$email = $user['email'] ?? '';
$role = $user['role'] ?? 'admin';
$profile_picture = !empty($user['profile_picture']) ? BASE_URL . '/public/' . $user['profile_picture'] : BASE_URL . '/assets/3.jpg';
$navLinks = [
    [
        'href' => BASE_URL . '/adminIndex.php?action=dashboard',
        'icon' => 'home',
        'label' => 'Dashboard',
    ],
    [
        'href' => BASE_URL . '/adminIndex.php?action=viewAllUsers',
        'icon' => 'users',
        'label' => 'Users',
    ],
    [
        'href' => '#',
        'icon' => 'settings',
        'label' => 'Settings',
    ],
    [
        'href' => '#',
        'icon' => 'user-circle',
        'label' => 'Edit Profile',
        'onclick' => 'showEditProfile && showEditProfile()',
    ],
];
include __DIR__ . '/unifiedSidebar.php';
?>
