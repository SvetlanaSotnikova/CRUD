# Docker Compose LEMP Stack

This repository contains a little `docker-compose` configuration to start a `LEMP (Linux, Nginx, MariaDB, PHP)` stack.

## Details

The following versions are used.

* PHP 7.2 (FPM) - With MySQLi driver optionally (Uncomment line from php.Dockerfile)
* Nginx 1.13.6
* MariaDB 10.3.9

## Configuration

The Nginx configuration can be found in `config/nginx/`.

You can also set the following environment variables, for example in the included `.env` file:

| Key | Description |
|-----|-------------|
|APP_NAME|The name used when creating a container.|
|MYSQL_ROOT_PASSWORD|The MySQL root password used when creating the container.|

## Usage

To use it, simply follow the following steps:

##### Clone this repository.

Clone this repository with the following command: `git clone https://github.com/stevenliebregt/docker-compose-lemp-stack.git`.

##### Start the server.

Start the server using the following command inside the directory you just cloned: `docker-compose up`.

## Entering the containers

You can use the following command to enter a container:

Where `{CONTAINER_NAME}` is one of:

`docker exec -ti {CONTAINER_NAME} /bin/bash`

# CRUD PROJECT
## Visible Site
![image](https://github.com/user-attachments/assets/03519312-6939-4c8f-b8b7-1ea39d6e6ddf)

## MyPhpAdmin
создала файл .yml чтобы установить этот phpAdmin и иметь постоянный доступ к бд
![image](https://github.com/user-attachments/assets/1211dc55-b869-405d-b2c0-4f560afbd3ad)

## Method CREATE

```
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
```

![image](https://github.com/user-attachments/assets/7943c496-23e1-4434-9440-a551e4bd39c2)
далее видно, что данные сохранились в базу данных с флагом 0 (видимым для пользователя)
![image](https://github.com/user-attachments/assets/399382a1-1950-4434-a4a6-8f4af93c042d)

## Method READ

```
// read
$sql = $pdo -> prepare("SELECT * FROM user WHERE flag = 0");
$sql -> execute();
$result = $sql -> fetchAll(PDO::FETCH_OBJ);
```

Сразу после создания, мы видим новую строку в нашей таблице на сайте, сайт синхронизирован с бд
![image](https://github.com/user-attachments/assets/14a4343d-a214-466a-98db-93abaf3a4c1c)


## Method UPDATE

```
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
```

Он существует, чтобы изменять уже записынные данные на сервере, изменения мы так же видим на сайте
Вот как выглядет форма для изменения данных:
![image](https://github.com/user-attachments/assets/c8ecf897-632f-4ade-b40f-ce663334285c)

дальше мы видим, что данные изменились и на сервере
![image](https://github.com/user-attachments/assets/bc24dc5f-9760-45e2-bff5-9632998af119)

на сайте это так же отображается
![image](https://github.com/user-attachments/assets/78370883-a5b4-490e-a0d8-44f527d0d0c2)


## Method DELETE

```
// delete
if (isset($_POST['delete'])) {
    $sql = ("UPDATE user SET flag = 1 WHERE id = ?");
    $query = $pdo->prepare($sql);
    $query -> execute([$get_id]);
    if ($query) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
```

Я использовальзовала Update потому что удалять все данные из базы данных - не есть хорошо, поэтому я меняю flag на еденицу, показывая серверу, чтобы сервер не отображал "удаленную" запись из нашей таблицы
вот как выглядит окно для удаления:
![image](https://github.com/user-attachments/assets/62e5dd1e-f74c-4f7c-9e48-8770724aa69e)

само удаление:
![image](https://github.com/user-attachments/assets/2c57be65-7f15-4b39-af32-73c20d704a8f)

а так же, вот как выглядит наша запись в бд на сервере:
![image](https://github.com/user-attachments/assets/dfb0b6ac-5ba3-4f5d-b7e3-8db03e70b04a)

мы видим, что страка, которую мы "удалили" больше не отображается для пользователя, но существует в нашей бд помеченной как удаленная 

## на этом презентация законченна, всем хорошего дня и удачи :D




* `{APP_NAME}-php`
* `{APP_NAME}-nginx`
* `{APP_NAME}-mariadb`
