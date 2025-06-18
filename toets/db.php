<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=filmclub", "root", "");
}   catch (PDOException $e){
    die("Error". $e-> getMessage());
}


?>