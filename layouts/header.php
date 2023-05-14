<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Объявления</title>
    <link rel="stylesheet" href="assets/index.css">
</head>
<body>
<header>
    <section>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Главная страница</a></li>

                <?php if (isAuthenticated()): ?>
                    <li><a href="ads.php">Объявления</a></li>
                    <li>
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li>
                        <form method="post" action="logout.php">
                            <button class="logout-button" type="submit">Выйти</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="login.php">Войти</a></li>
                    <li><a href="register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </section>
</header>

