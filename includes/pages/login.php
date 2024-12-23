<?php
/**
 * Файл авторизации пользователя.
 * 
 * Подключает конфигурационный файл и файл с настройками базы данных.
 * Обрабатывает форму авторизации, проверяет введенные данные и выполняет вход пользователя.
 */

require '../config/config.inc.php'; // Подключение конфигурационного файла
require MYSQL; // Подключение файла с настройками базы данных


$login_errors = array(); // Массив для хранения ошибок регистрации

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Проверка наличия имени пользователя
    if (!empty($_POST['username'])){
        $username = escape_data($_POST['username'], $dbc);
    } else {
        $login_errors['username'] = "Логин не может быть пустой!";
    }

    // Проверка наличия пароля
    if (!empty($_POST['password'])){
        $pass = escape_data($_POST['password'], $dbc);
    } else {
        $login_errors['password'] = "Пароль не может быть пустой!";
    }

    // Если нет ошибок, проверка данных пользователя в базе данных
    if (empty($login_errors)){

        $q = "SELECT id, login, role, password FROM users WHERE login='$username'";
        $r = mysqli_query($dbc, $q);

        // Если пользователь найден
        if (mysqli_num_rows($r) === 1) {
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            // Проверка пароля
            if (password_verify($pass, $row['password'])) {
                // Создание новой сессии для администратора
                if ($row['role'] === 'admin') {
                    session_regenerate_id(true);
                    $_SESSION['user_admin'] = true;
                } else {
                    $_SESSION['user_admin'] = false;
                }

                // Сохранение данных пользователя в сессии
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                // Перенаправление пользователя
                header('Location: index.php');
                exit();
            } else {
                $login_errors['login'] = 'Логин и/или пароль некорректны.';
            }
        } else{
            $login_errors['login'] = 'Логин и/или пароль некорректны.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Авторизация</title>
</head>
<body>
    
    <div class="main-page__link">
        <p><a href="index.php"><span>&#8592;</span> На главную</a></p>
    </div>

    <div class="authorization">
        <div class="authorization__content">

            <div class="authorization-logo">
                <div class="footer__logo">
                    <h4>MoiNEsam</h4>
                </div>
            </div>

            <form action="login.php" method="post" accept-charset="utf-8" id="registration_form">

                <label> <?php if (!empty($login_errors['login'])){
                    echo $login_errors['login'];
                }?></label>

                <div class="input-container">

                    <div class="input-group">
                        <input name="username" type="text" placeholder="Введите логин">
                        <label for="username"><?php if (!empty($login_errors['username'])){
                            echo $login_errors['username'];
                        }?></label>
                    </div>
                    
                    <div class="input-group">
                        <input name="password" type="password" placeholder="Введите пароль">
                        <label for="password"><?php if (!empty($login_errors['password'])){
                            echo $login_errors['password'];
                        }?></label>
                    </div>

                </div>
                
                <input type="submit" value="ВОЙТИ" id="registration_submit">

            </form>

        </div>
    </div>

</body>
</html>