<?php
require_once 'functions/index.php';

// Выставляем какие данные будут приходить в результате запроса
header("Content-Type: application/json");

// Проверка на авторизацию пользователя и метод запроса
if (!isAuthenticated() || $_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Нет доступа"]);
    exit();
}

// Обрабатываем данные для отправки
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$user_id = $_SESSION['user_id'];


// Формируем ответ в формате JSON, в зависимости от результата создания
if (createAd($title, $description, $user_id)) {
    echo json_encode([
        "success" => true,
        "ad" => [
            "title" => $title,
            "description" => $description,
            "username" => $_SESSION['username']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Ошибка сервера. Пожалуйста, попробуйте снова"]);
}