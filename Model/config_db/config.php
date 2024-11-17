<?php

$db = "mysql:host=localhost;dbname=gestion_u";
$user = "root";
$password = "";

try {
    $connect = new PDO($db, $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to detect the problem in the try block
} catch (PDOException $e) {
    echo 'Problem: ' . $e->getMessage(); // Correct concatenation with '.'
}

?>