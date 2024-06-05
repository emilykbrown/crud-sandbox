<?php

$host = "localhost";
$dbName = "test";
$userName = "root";
$password = "";

try {
    $con = new PDO("mysql:host={$host};dbname={$dbName}", $userName, $password);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}

?>
