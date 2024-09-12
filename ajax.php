<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = trim($_POST['value'] ?? '');
    $safeValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

    if ($safeValue !== '') {
        try {
            $query = $db->prepare("SELECT * FROM results WHERE description LIKE :value ORDER BY description LIMIT 5");
            $query->execute([':value' => "%$safeValue%"]);

            if ($query->rowCount() > 0) {
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                usort($results, function($a, $b) {
                    return strcmp($b->description, $a->description);
                });

                foreach ($results as $item) {
                    echo "<a href='get.php?id=" . htmlspecialchars($item->id, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($item->description, ENT_QUOTES, 'UTF-8') . "</a><br>";
                }
            } else {
                echo "<b>No results matched your search!</b>";
            }
        } catch (PDOException $e) {
            echo "<b>Error:</b> " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>
