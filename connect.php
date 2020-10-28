<?php
try{
    $db = new PDO("mysql:host=localhost;dbname=livesearch;charset=UTF8","tolga","123456");//write your database name correctly
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo $e->getMessage();
    die();
}

?>