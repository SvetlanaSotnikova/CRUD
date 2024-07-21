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

}

function handleRequest() {
    $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $content = null;
    $fullPage = null;
    $title = null;

    switch ($route) {
        case '/':
            $content = renderTemplate('./views/list.php', [
                'title' => 'Главная',
                'description' => 'CRUD Приложение',
                'users' => getUsers(),
            ]);
            break;
            
        case '/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['email'])) {
                updateUser($_POST['id'], $_POST['email'], $_POST['name']);
                
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
            break;

        case '/create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'])) {
                createUser($_POST['email'], $_POST['name']);
                
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
            break;

        case '/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                deleteUser($_POST['id']);
                
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
            break;

        default:
            $content = renderTemplate('./views/404.php', [
                'title' => '404',
                'description' => 'Страницы не существует',
            ]);
            break;
    }

    if (!is_null($content)) {
        $fullPage = renderTemplate('./views/mainLayout.php', [
            'title' => $title,
            'content' => $content
            // 'users' => getUsers(),
        ]);

        return $fullPage;
    }
}


function init() {
    echo handleRequest();
}

function renderTemplate($templatePath, $variables = []) {

    // Извлекаем переменные из массива
    extract($variables);
    
    // Включаем буферизацию вывода
    ob_start();
    
    // Подключаем файл шаблона
    if (file_exists($templatePath)) {
        require $templatePath;
    } else {
        echo "Файл шаблона не найден: $templatePath";
    }
    
    // Получаем содержимое буфера
    $content = ob_get_clean();
    
    return $content;
  }