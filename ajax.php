<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = trim($_POST['value'] ?? '');

    if ($value !== '') {
        $query = $db->prepare("SELECT * FROM results WHERE description LIKE :value ORDER BY description LIMIT 5");
        $query->execute([':value' => "%$value%"]);

        if ($query->rowCount() > 0) {
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            rsort($results);

            foreach ($results as $item) {
                echo "<a href='get.php?id={$item->id}'>{$item->description}</a><br>";
            }
        } else {
            echo "<b>No results matched your search!</b>";
        }
    }
}
?>
