<?php
include_once 'functions/index.php';

// Проверка что пользователь авторизирован
if (isAuthenticated()) {
    header("Location: index.php");
    exit();
}

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $errors = [];

    // Валидация данных
    if (empty($username)) {
        $errors[] = "Требуется логин";
    }
    if (empty($password)) {
        $errors[] = "Требуется пароль";
    }

    if (empty($errors)) {
        if (loginUser($username, $password)) {
            exit();
        } else {
            $errors[] = "Неверный логин или пароль";
        }
    }
}

include_once 'layouts/header.php';
?>

<main>
    <section class="form-container">
        <h2>Авторизация</h2>
        <form action="login.php" method="post">
            <label for="username">Логин</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Войти</button>
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

<?php
include_once 'layouts/footer.php';
?>
