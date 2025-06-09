<?php

if (session_status() === PHP_SESSION_NONE) session_start();

// Get environment variables with fallback values
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'vas_care';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';

function getConnection(): mysqli{
    global $db_host, $db_name, $db_user, $db_pass;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        $_SESSION['error'] = "Database connection failed. Please try again later.";
    }
    return $conn;
}
?>

