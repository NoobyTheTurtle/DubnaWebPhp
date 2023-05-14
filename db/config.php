<?php
// Креды для работы с БД
$host = 'localhost';
$dbname = 'restapi_dev';
$username = '';
$password = '';

// Подключение к БД, $pdo - глобальная переменная для взаимодействия с БД
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}
