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
        'data' => [],
        'count' => 0
    ]);
    exit;
}

try {
    // Escape LIKE wildcard characters to prevent unintended matching of '%' and '_'
    $escapedValue = addcslashes($value, '%_');

    // Perform database search with wildcard match and sort alphabetically ascending directly in SQL
    $query = $db->prepare("SELECT id, description FROM results WHERE description LIKE :value ORDER BY description ASC LIMIT 8");
    $query->execute([':value' => "%$escapedValue%"]);

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    // Structure each item into title, category and raw description for enhanced UI
    $results = array_map(function($row) {
        $parts = explode(' - ', $row['description'], 2);
        return [
            'id' => (int) $row['id'],
            'title' => trim($parts[0]),
            'category' => isset($parts[1]) ? trim($parts[1]) : 'Technology',
            'description' => $row['description']
        ];
    }, $rows);

    echo json_encode([
        'success' => true,
        'data' => $results,
        'count' => count($results),
        'query' => $value
    ]);
} catch (PDOException $e) {
    error_log("Search query error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while searching. Please try again.'
    ]);
}
