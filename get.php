<?php
require_once 'connect.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$item = null;
if ($id !== false && $id !== null) {
    try {
        $query = $db->prepare("SELECT * FROM results WHERE id = :id LIMIT 1");
        $query->execute([':id' => $id]);
        $item = $query->fetch();
    } catch (PDOException $e) {
        // Log or handle error gracefully
    }
}

// Split the description into title and detail if structured as "Title - Detail"
$title = "Not Found";
$subtitle = "The requested item could not be found.";
if ($item) {
    $parts = explode(' - ', $item->description, 2);
    $title = htmlspecialchars($parts[0], ENT_QUOTES, 'UTF-8');
    $subtitle = htmlspecialchars($parts[1] ?? 'Technical Framework / Language', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Strict and secure Content-Security-Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self';">
    
    <title><?php echo $item ? $title : "Item Not Found"; ?> - Details</title>
    
    <!-- Premium stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="details-container">
        <?php if ($item): ?>
            <div class="details-badge">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <h2><?php echo $title; ?></h2>
            <p><?php echo $subtitle; ?></p>
        <?php else: ?>
            <div class="details-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2>Not Found</h2>
            <p>The details you are looking for do not exist or have been removed.</p>
        <?php endif; ?>
        
        <a href="index.php" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Search
        </a>
    </div>

</body>
</html>
