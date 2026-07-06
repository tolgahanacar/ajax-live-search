<?php
// Set headers for JSON response and security
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method Not Allowed'
    ]);
    exit;
}

$value = trim($_POST['value'] ?? '');

if ($value === '') {
    echo json_encode([
        'success' => true,
        'data' => []
    ]);
    exit;
}

try {
    // Perform database search with wildcard match and sort alphabetically ascending directly in SQL
    $query = $db->prepare("SELECT id, description FROM results WHERE description LIKE :value ORDER BY description ASC LIMIT 5");
    $query->execute([':value' => "%$value%"]);

    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $results
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database query failed: ' . $e->getMessage()
    ]);
}
