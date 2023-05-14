<?php
require_once 'functions/index.php';

// Проверка что пользователь авторизирован
if (isAuthenticated()) {
    header("Location: index.php");
    exit();
}

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    $errors = [];

    // Валидация входных параметров
    if (empty($username)) {
        $errors[] = "Требуется логин";
    }
    if (empty($email)) {
        $errors[] = "Требуется email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Недопустимый формат email";
    }
    if (empty($password)) {
        $errors[] = "Требуется пароль";
    } elseif (strlen($password) < 8) {
        $errors[] = "Пароль должен содержать не менее 8 символов";
    }
    if ($password != $password_confirm) {
        $errors[] = "Пароли не совпадают";
    }

    if (empty($errors)) {
        $result = registerUser($username, $email, $password);
        if ($result === true) {
            header("Location: login.php");
            exit();
        } else {
            $errors[] = $result;
        }

    }
}

require_once 'layouts/header.php';
?>

<main>
    <section class="form-container">
        <h2>Регистрация</h2>
        <form action="register.php" method="post">
            <label for="username">Логин</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" minlength="8" required>

            <label for="password_confirm">Повторите пароль</label>
            <input type="password" name="password_confirm" id="password_confirm" minlength="8" required>

            <button type="submit">Отправить</button>
        </form>

        <?php
        // Выводим ошибки, если такие имеются
        if (!empty($errors)) {
            echo "<ul class='errors'>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul>";
        }
        ?>
    </section>
</main>

<?php require_once 'layouts/footer.php'; ?>
