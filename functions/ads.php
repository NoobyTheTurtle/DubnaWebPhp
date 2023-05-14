<?php

// Получение списка объявлений
function getAds(): false|array
{
    global $pdo;

    // Получение объявлений + логин пользоваля объявления
    $statement = $pdo->query("
        SELECT ads.*, users.username FROM ads 
        INNER JOIN users ON ads.user_id = users.id 
        ORDER BY created_at DESC
    ");

    return $statement->fetchAll();
}

// Создание объявления
function createAd($title, $description, $user_id): bool
{
    global $pdo;

    // Создание объявления в БД со входными параметрами
    $statement = $pdo->prepare("INSERT INTO ads (title, description, user_id) VALUES (:title, :description, :user_id)");
    $result = $statement->execute(['title' => $title, 'description' => $description, 'user_id' => $user_id]);

    // Проверка успешности создания объявления
    if ($result) {
        return true;
    } else {
        return false;
    }
}
