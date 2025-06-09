<?php

// Define the base path
define('BASE_PATH', __DIR__ . '/../src');

// Include the autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Get the request URI
$request_uri = $_SERVER['REQUEST_URI'];

// Remove query string if present
if (($pos = strpos($request_uri, '?')) !== false) {
    $request_uri = substr($request_uri, 0, $pos);
}

// Remove trailing slash
$request_uri = rtrim($request_uri, '/');

// If the request is for the root path
if ($request_uri === '' || $request_uri === '/') {
    require_once BASE_PATH . '/index.php';
    exit;
}

// For other routes, try to find the corresponding file
$file_path = BASE_PATH . $request_uri . '.php';

if (file_exists($file_path)) {
    require_once $file_path;
} else {
    $view_path = BASE_PATH . '/views' . $request_uri . '.php';
    if (file_exists($view_path)) {
        require_once $view_path;
    } else {
        // If still not found, return 404
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
    }
} 