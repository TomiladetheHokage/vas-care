<?php
$host = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];

if (str_contains($host, 'onrender.com')) {
    define('BASE_URL', ''); // For Render deployment
} elseif ($port == 8000) {
    define('BASE_URL', ''); // For PHP built-in server
} else {
    define('BASE_URL', '/vas-care/src'); // For XAMPP or Apache in a subfolder
}

// Make sure BASE_URL is available globally
if (!defined('BASE_URL')) {
    define('BASE_URL', '/vas-care/src'); // Fallback default
}
?>
