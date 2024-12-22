<?php

session_unset();

// Завершаем сессию
session_destroy();

// Опционально: Перенаправляем пользователя, чтобы обновить состояние страницы

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/'); // Удаляем cookie сессии
}

header("Location: index.php");
exit();