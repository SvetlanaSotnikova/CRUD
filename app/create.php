<?php
    include "config.php";
   
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $get_id = $_GET['id'] ?? null;

// create
if (isset($_POST['add'])) {

    if (empty($email)) {
        $error = "Email should not be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {  
        try {
            $sql = ("INSERT INTO user (name, email, flag) VALUES (?,?, 0)");
            $query = $pdo->prepare($sql);
            $query -> execute([$name, $email]);

            if ($query) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    }
}


// read
$sql = $pdo -> prepare("SELECT * FROM user WHERE flag = 0");
$sql -> execute();
$result = $sql -> fetchAll(PDO::FETCH_OBJ);


// update
if (isset($_POST['edit'])) {
    if (empty($email)) {
        $error = "Email should not be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        try {
            $sql = ("UPDATE user SET name=?, email=? WHERE id=?");
            $query = $pdo->prepare($sql);
            $query -> execute([$name, $email, $get_id]);
            if ($query) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    }   
}


// delete
if (isset($_POST['delete'])) {
    $sql = ("UPDATE user SET flag = 1 WHERE id = ?");
    $query = $pdo->prepare($sql);
    $query -> execute([$get_id]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}