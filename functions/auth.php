<?php


// Получение пользователя
function fetchUser($username, $email = null)
{
    global $pdo;

    // Взависимости от входных параметров происходит поиск пользователя в БД
    if ($email) {
        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $statement->execute(['username' => $username, 'email' => $email]);
    } else {
        $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $statement->execute(['username' => $username]);
    }

    return $statement->fetch();
}

// Регистрация пользователя
function registerUser($username, $email, $password): true|string
{
    global $pdo;

    $user = fetchUser($username, $email);

    // Проверка на уже существующего пользователя с такими данными
    if ($user) {
        return "Пользователь с такими данными уже существует";
    }

    // Хэширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Создание пользователя в БД
    $statement = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $result = $statement->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password,
    ]);
    // Получение созданного пользователя
    $user = fetchUser($username, $email);

    if ($result && $user) {
        // Сохранение данных о пользователи в сессию
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        return true;
    }

    return "Ошибка сервера. Пожалуйста, попробуйте снова";
}

// Логин пользователя
function loginUser($username, $password): bool
{
    // Получение пользователя
    $user = fetchUser($username);

    // Проверка что пользователь найден и сверка хэша пароля
    if ($user && password_verify($password, $user['password'])) {

        // Сохранение данных о пользователи в сессию
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: ads.php");
        return true;
    }

    return false;
}

// Проверка авторизирован ли пользователь
function isAuthenticated(): bool
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}