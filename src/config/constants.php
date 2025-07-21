<?php
$host = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];

// BASE_URL logic for all environments
if (isset($_SERVER['RENDER']) && $_SERVER['RENDER'] === 'true') {
    // Render.com environment
    define('BASE_URL', '');
} elseif (php_sapi_name() === 'cli-server') {
    // PHP built-in server
    define('BASE_URL', '');
} else {
    // Apache or similar, project in /vas-care
    define('BASE_URL', '/vas-care');
}
?>
