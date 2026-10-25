<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'livesearch';
$dbUser = getenv('DB_USER') ?: 'tolga';
$dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '123456';

try {
    $db = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Log error internally without exposing sensitive details to end users
    error_log("Database connection error: " . $e->getMessage());

    $isPost = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    // If it's a POST/AJAX request, return a clean JSON error response
    if ($isPost || $isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database connection error. Please verify database availability.'
        ]);
        exit;
    }
    
    // Normal page load error
    http_response_code(500);
    die("Database connection failed. Please verify database availability and server configuration.");
}

