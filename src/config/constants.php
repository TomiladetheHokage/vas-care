<?php
$host = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];

if (!defined('BASE_URL')) {
    if (str_contains($host, 'onrender.com')) {
        define('BASE_URL', '');
    } elseif ($port == 8000) {
        define('BASE_URL', '');
    } else {
        define('BASE_URL', '/vas-care/src');
    }
}
?>
