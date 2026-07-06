<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=livesearch;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]);
} catch (PDOException $e) {
    // If it's a POST/AJAX request, return a clean JSON error response
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'Database connection error. Please verify database availability.'
        ]);
        exit;
    }
    
    // Normal page load error
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
