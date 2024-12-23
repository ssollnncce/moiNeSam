<?php

/**
 * Файл создания заказа.
 * 
 * Подключает конфигурационный файл и файл с настройками базы данных.
 * Обрабатывает форму создания заказа, проверяет заполненные поля и отправляет заявку на рассмотрение администратору.
 */

require '../config/config.inc.php'; // Подключение конфигурационного файла
require MYSQL; // Подключение файла с настройками базы данных

$title = 'Создать заявку'; // Заголовок страницы

include 'header.html'; // Включение заголовка страницы

$create_order_errors = array(); // Массив для хранения ошибок

$uid = $_SESSION['user_id']; // Получение идентификатора пользователя из сессии

// Опции для типа уборки
$type_options = [
    'base' => 'Общий клининг',
    'general' => 'Генеральная уборка',
    'construction' => 'Послестроительная уборка',
    'furniture' => 'Химчистка ковров и мебели',
    'custom' => 'Иная услуга'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Проверка адреса
    if (preg_match('/^[A-Za-zА-Яа-я \'.-]{2,45}$/u', $_POST['adress'])) {
        $ad = escape_data($_POST['adress'], $dbc);
    } else {
        $create_order_errors['adress'] = 'Пожалуйста, укажите адрес!';
    }

    // Проверка номера телефона
    if (preg_match('/^(\+7|8)?\d{10}$/', $_POST['phone']) ) {
        $pho = $_POST['phone'];
    } else {
        $create_order_errors['phone'] = 'Пожалуйста, введите корректный номер телефона!';
    }

    // Проверка описания уборки
    if (empty($_POST['custom_type'])){
        $dc = escape_data($_POST['custom_type'], $dbc);
    } else {
        if (preg_match('/^[A-Za-zА-Яа-я \'.-]{2,45}$/u', $_POST['custom_type'])) {
            $dc = escape_data($_POST['custom_type'], $dbc);
        } else {
            $create_order_errors['custom_type'] = "Укажите описание уборки";
        }
    }

    $type = isset($_POST['type']) ? escape_data($_POST['type'], $dbc) : 'custom'; // Получение типа уборки
    $payment = escape_data($_POST['payment'], $dbc); // Получение способа оплаты

    // Если нет ошибок, вставляем данные в базу
    if (empty($create_order_errors)){

        $q = "INSERT INTO orders (user_id, adress, type, custom_type, payment, phone) values ( '$uid', '$ad', '$type', '$dc', '$payment', '$pho' )";
        $r = mysqli_query($dbc, $q);

    } else {
        echo 'Что-то пошло не так'; // Сообщение об ошибке
    }

}

?>

    <div class="main-content create-order">
        <h2>Создать заявку</h2>

        <form action="create_order.php" method="post" accept-charset="utf-8" id="create_orders">

            <div class="orders_input-container">

                <div class="order__input-container">

                    <div class="order__input-container-2">
                        <input type="text" name="adress" placeholder="Введите адрес">
                        <label for="adress">Формат адреса: город, улица, номер дома - квартира (если есть) </label>
                        <label for="adress"><?php if (!empty($create_order_errors['adress'])){
                            echo $create_order_errors['adress'];}?></label>
                    </div>

                    <div class="order__input-container-2">
                        <input type="text" name="phone" placeholder="+7 (___) ___ - __ - __">
                        <label for="phone"><?php if (!empty($create_order_errors['phone'])){
                            echo $create_order_errors['phone'];}?></label>
                    </div>
                    

                </div>

                <div class="order__input-container">

                    <div class="order__input-container-2">

                        <select name="type" class="form-select" aria-label="Cleaning type" id="cleaning_type">
                            <?php
                                $first_option = true; // Флаг для первой опции
                                foreach ($type_options as $value => $label) {
                                    // Пропускаем "custom"
                                    if ($value !== 'custom') {
                                        echo "<option value='$value'" . ($first_option ? " selected" : "") . ">$label</option>";
                                        $first_option = false; // Убираем флаг после первой опции
                                    } else {
                                        echo "<option value='$value' disabled>$label</option>";
                                    }
                                }
                            ?>
                        </select>
                        
                        <div class="another-order">
                            <input type="checkbox" name="custom_type_check" id="custom_type_check">
                            <label for="custom_type_check">Иная услуга</label>
                        </div>

                    </div>

                    <div class="order__input-container-2">
                            <textarea type="text" placeholder="Напишите описание уборки здесь..." id="custom-type__text" name="custom_type"></textarea>
                            <label for="custom_type"><?php if (!empty($create_order_errors['custom_type'])){
                            echo $create_order_errors['custom_type'];}?></label>
                    </div>

                </div>

                <div class="payment_container">

                    <div class="order__input-container-2">
                        <input type="radio" id="payment_cash" name="payment" value="cash">
                        <label for="payment_cash" class="payment-label"><span><i class="fa-solid fa-wallet"></i></span>Наличные</label>
                    </div>

                    <div class="order__input-container-2">
                        <input type="radio" id="payment_card" name="payment" value="card" checked>
                        <label for="payment_card" class="payment-label"><span><i class="fa-solid fa-credit-card"></i></span>По карте</label>
                    </div>

                </div>

            </div>
            
            <div class="order_submit">
                <input type="submit" value="Отправить заявку" id="order-submit">
            </div>
        </form>    
    </div>

<?php

include 'footer.html'; // Включение подвала страницы

?>
