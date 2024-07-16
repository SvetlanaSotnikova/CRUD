<?php
    $servername = "mariadb";
    $username = "root";
    $password = "root";
    $dbname = "mydb";

    try {
        $pdo = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);  
    } catch (PDOException $e) {
        echo 'something wrong :( '. $e->getMessage();
}