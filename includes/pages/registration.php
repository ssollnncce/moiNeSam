<?php

require '../config/config.inc.php';

require MYSQL;

$reg_errors = array(
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (preg_match('/^[A-Za-zА-Яа-я \'.-]{2,45}$/u', $_POST['first_name'])) {
		$fn = escape_data($_POST['first_name'], $dbc);
	} else {
		$reg_errors['first_name'] = 'Пожалуйста, укажите свое имя!';
	}

    if (preg_match('/^[A-Za-zА-Яа-я \'.-]{2,45}$/u', $_POST['second_name'])) {
		$sn = escape_data($_POST['second_name'], $dbc);
	} else {
		$reg_errors['second_name'] = 'Пожалуйста, введите фамилию!';
	}

    if (preg_match('/^[A-Za-zА-Яа-я \'.-]{2,45}$/u', $_POST['patronomyc'])) {
		$pt = escape_data($_POST['patronomyc'], $dbc);
	} else {
		$reg_errors['patronomyc'] = 'Пожалуйста, введите отчество!';
	}

    if (preg_match('/^[A-Za-z0-9_-]{5,20}$/', $_POST['username'])) {
        $username = escape_data($_POST['username'], $dbc);

        // Проверка уникальности логина
        $q = "SELECT id FROM users WHERE login = '$username'";
        $r = mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) > 0) {
            $reg_errors['username'] = 'Этот логин уже занят. Пожалуйста, выберите другой.';
        }
    } else {
        $reg_errors['username'] = 'Логин должен быть длиной от 5 до 20 символов и содержать только латинские буквы, цифры, тире или подчеркивание.';
    }

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']) {
		$e = escape_data($_POST['email'], $dbc);
	} else {
		$reg_errors['email'] = 'Пожалуйста, укажите корректный адрес электронной почты!';
	}

    if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $_POST['password']) ) {
		$p = $_POST['password'];
	} else {
		$reg_errors['password'] = 'Пожалуйста, введите корректный пароль!';
	}

    if (preg_match('/^(\+7|8)?\d{10}$/', $_POST['phone']) ) {
		$pho = $_POST['phone'];
	} else {
		$reg_errors['phone'] = 'Пожалуйста, введите корректный номер телефона!';
	}

    if (empty($reg_errors)) {

        $q = "INSERT INTO users (first_name, second_name, patronomyc, login, password, email, phone, role) VALUES ('$fn', '$sn', '$pt', '$username', '". password_hash($p, PASSWORD_BCRYPT) . "' , '$e', '$pho', 'member')";
        $r = mysqli_query($dbc, $q);

        if (mysqli_affected_rows($dbc) === 1) {
	
            $uid = mysqli_insert_id($dbc);
            $_SESSION['reg_user_id']  = $uid;
             
            header("Location: login.php");
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css"></link>
    <title>Регистрация</title>
</head>
<body>

    <div class="main-page">
        <p><a href="index.php"><span>&#8592;</span> На главную</a></p>
    </div>

    <div class="registration">

        <div class="registration__content">

            <div class="registration-logo">
                <div class="footer__logo">
                    <h4>MoiNEsam</h4>
                </div>
            </div>

            <form action="registration.php" method="post" accept-charset="utf-8" id="registration_form">

                <div class="input-container">

                    <div class="input-group">
                        <input name="username" type="text" placeholder="Введите логин">
                        <label for="username"><?php if (!empty($reg_errors['username'])){
                            echo $reg_errors['username'];
                        }
                            ?></label>
                    </div>
                        
                    <div class="input-group-2">

                        <div class="input-group-2__container">
                            <input name="first_name" type="text" placeholder="Введите имя">
                            <label for="first_name"><?php if (!empty($reg_errors['first_name'])){
                                echo $reg_errors['first_name'];
                            }?></label>
                        </div>
                        
                        <div class="input-group-2__container">
                            <input name="second_name" type="text" placeholder="Введите фамилию">
                            <label for="second_name"><?php if (!empty($reg_errors['second_name'])){
                                echo $reg_errors['second_name'];
                            }?></label>
                        </div>

                    </div>

                    <div class="input-group">
                        <input name="patronomyc" type="text" placeholder="Введите отчество">
                        <label for="patronomyc"><?php if (!empty($reg_errors['patronomyc'])){
                            echo $reg_errors['patronomyc'];
                        }?></label>
                    </div>

                    <div class="input-group">
                        <input name="phone" type="text" placeholder="Введите номер телефона">
                        <label for="phone"><?php if (!empty($reg_errors['phone'])){
                            echo $reg_errors['phone'];
                        }?></label>
                    </div>
                    
                    <div class="input-group">
                        <input name="email" type="text" placeholder="Введите адрес электронной почты">
                        <label for="email"><?php if (!empty($reg_errors['email'])){
                            echo $reg_errors['email'];
                        }?></label>
                    </div>
                    
                    <div class="input-group">
                        <input name="password" type="password" placeholder="Введите пароль">
                        <label><?php if (!empty($reg_errors['password'])){
                            echo $reg_errors['password'];
                        }?></label>
                    </div>


                </div>
                
                <input type="submit" value="ЗАРЕГИСТРИРОВАТЬСЯ" id="registration_submit">
            </form>
        </div>
    </div>

</body>
</html>