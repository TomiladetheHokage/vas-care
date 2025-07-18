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
} elseif (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/vas-care/src/') === 0) {
    // Apache or similar, project in /vas-care/src
    define('BASE_URL', '/vas-care/src');
} else {
    // Fallback
    define('BASE_URL', '');
}
?>
