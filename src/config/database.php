<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load environment variables from .env file
$env = parse_ini_file(__DIR__ . '/../../.env');

// Database configuration
$db_host = $env['DB_HOST'];
$db_name = $env['DB_NAME'];
$db_user = $env['DB_USER'];
$db_pass = $env['DB_PASSWORD'];
$db_port = isset($env['DB_PORT']) ? (int)$env['DB_PORT'] : 3306; // default MySQL port

/**
 * Establish a MySQL database connection.
 *
 * @return mysqli
 */
function getConnection(): mysqli {
    global $db_host, $db_name, $db_user, $db_pass, $db_port;

    try {
        // Enable exception mode
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Create connection
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

        // Set character encoding
        $conn->set_charset("utf8mb4");

        return $conn;
    } catch (mysqli_sql_exception $e) {
        // Optional: log actual error
        error_log("DB Connection Error: " . $e->getMessage());

        // Show friendly message
        echo "<div style='
            padding: 1rem;
            margin: 2rem auto;
            max-width: 600px;
            background-color: #ffe5e5;
            border-left: 4px solid #ff4d4d;
            color: #b30000;
            font-family: sans-serif;
            text-align: center;
        '>
            <strong>Sorry!</strong> We couldn’t connect to the database right now.<br>
            Please try again shortly.
        </div>";
        exit;
    }
}
