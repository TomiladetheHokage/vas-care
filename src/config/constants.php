<?php
// Get the current script path relative to the web root, e.g. '/vas-care/src/index.php'
$scriptPath = $_SERVER['SCRIPT_NAME'];

// Usually, index.php is at the base, so get its directory (e.g., '/vas-care/src')
$baseDir = rtrim(dirname($scriptPath), '/\\');

// For Render or when served at root, this might be just '' or '/'
// To standardize, if baseDir is '/', set it to empty string
if ($baseDir === '/' || $baseDir === '\\') {
    $baseDir = '';
}

define('BASE_URL', $baseDir);
?>
