<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    $envFilepath = "$root/.env";

    if (is_file($envFilepath)) {
        $file = new \SplFileObject($envFilepath);

        while (false === $file->eof()) {
            $line = trim($file->fgets());
            if (!empty($line) && strpos($line, '=') !== false) {
                putenv($line);
            }
        }
    }


    $servername = "mariadb";
    $username = getenv("APP_NAME");
    $password = getenv("MYSQL_ROOT_PASSWORD");
    $dbname = "mydb";

    try {
        $pdo = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);  
    } catch (PDOException $e) {
        echo 'something wrong :( '. $e->getMessage();
}