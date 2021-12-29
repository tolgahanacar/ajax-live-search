<?php
require_once  'connect.php';
?>

<?php
if($_POST){
    $value = $_POST['value'];
    if ((!$value) or (empty($value))){

    }else{
        $query = $db->prepare("SELECT * FROM results WHERE description  LIKE '%$value%' ORDER BY description LIMIT 5 ");//the results you want to view the most
        $query->execute();
        $count = $query->rowCount();
        if ($count>0){
            $query2 = $query->fetchAll(PDO::FETCH_OBJ);
            rsort($query2);//Sort alphabetically
            foreach ($query2 as $item){
                echo "<a href='get.php?id=$item->id'>$item->description</a>"."<br>";
            }
        }else{
            echo "<b>"."No results matched your search!"."</b>";
        }

    }
}

?>
