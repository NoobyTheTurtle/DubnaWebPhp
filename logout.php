<?php
require_once 'functions/index.php';

// Проверка что пользователь авторизирован
if (isAuthenticated()) {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    session_destroy();
}

header("Location: login.php");
exit();

