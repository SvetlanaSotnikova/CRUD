<?php

    function getUsers() {
        global $pdo;
        try {
            $sql = $pdo->prepare("SELECT id, name, email  FROM user WHERE flag = 0");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    function getUser($id) {
        global $pdo;
        if (empty($id)) {
            return false;
        }

        try {
            $sql = $pdo->prepare("SELECT * FROM user WHERE id = ? AND flag = 0");
            $sql->execute([$id]);
            return $sql->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }
    function createUser($email, $name) {
        global $pdo;
        if (empty($email) || empty($name)) {
            return false;
        }
        try {
            $sql = ("INSERT INTO user (name, email, flag) VALUES (?,?, 0)");
            $query = $pdo->prepare($sql);
            $result = $query->execute([$name, $email]);
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }
    function deleteUser($id) {
        global $pdo;
        if (empty($id)) {
            return false;
        }

        try {
            $sql = $pdo->prepare("UPDATE user SET flag = 1 WHERE id = ?");
            $result = $sql->execute([$id]);
            return $result;
        } catch (PDOException $e) {
            return false;
    }
    }


    function updateUser($id, $email = null, $name = null) {
        global $pdo;
        if (empty($id) || (empty($email) && empty($name))) {
            return false;
        }
        
        $fields = [];
        $values = [];

        if (!empty($name)) {
            $fields[] = 'name = ?';
            $values[] = $name;
        }

        if (!empty($email)) {
            $fields[] = 'email = ?';
            $values[] = $email;
        }

        $values[] = $id; 
        
        $fields = implode(', ', $fields);
        
        try {
            $sql = "UPDATE user SET $fields WHERE id = ?";
            $query = $pdo->prepare($sql);
            $result = $query->execute($values);
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }
