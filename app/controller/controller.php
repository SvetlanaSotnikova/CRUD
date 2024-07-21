<?php

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $get_id = $_GET['id'] ?? null;


// create
if (isset($_POST['add'])) {

    $result = createUser($email,$name);
    if($result) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $error = "Failed to create user :(";
    }
    
}


// read
$users = getUsers();
if ($users) {
    $result = getUsers();
} else {
    $error = "Failed to fetch users :(";
}


// update
if (isset($_POST['edit'])) {
    
    $result = updateUser($get_id, $email, $name);
    if($result) {   
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $error = "Failed to update user :(";
    }
   
}


// delete
if (isset($_POST['delete'])) {
    $result = deleteUser($get_id);
    if($result) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $error = "Failed to delete user :(";
    }
    // $sql = ("UPDATE user SET flag = 1 WHERE id = ?");
    // $query = $pdo->prepare($sql);
    // $query -> execute([$get_id]);
    // if ($query) {
    //     header("Location: " . $_SERVER['HTTP_REFERER']);
    // }
}