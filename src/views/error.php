<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Vas Care</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #e74c3c;
            margin-bottom: 1rem;
        }
        .message {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .back-link {
            color: #3498db;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Oops! Something went wrong</h1>
        <div class="message">
            <?php echo isset($_SESSION['error']) ? htmlspecialchars($_SESSION['error']) : 'An unexpected error occurred.'; ?>
        </div>
        <a href="/" class="back-link">Return to Home</a>
    </div>
</body>
</html> 