<?php

if (session_status() === PHP_SESSION_NONE) session_start();

$env = parse_ini_file(__DIR__ . '/../../.env');

$db_host =  $env['DB_HOST'];
$db_name =  $env['DB_NAME'];
$db_user =  $env['DB_USER'];
$db_pass =  $env['DB_PASSWORD'];

function getConnection(): mysqli{
    global $db_host, $db_name, $db_user, $db_pass;

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) $_SESSION['error'] = "connection failed: " . $conn->connect_error;
    return $conn;
}
?>