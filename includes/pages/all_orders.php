<?php

require '../config/config.inc.php';
require MYSQL;

$title = 'Мои заказы';

include 'header.html';

$uid = $_SESSION['user_id'];

$query = "SELECT id, status, adress, type, payment, decklined_reason FROM orders WHERE user_id = '$uid'";
$result = mysqli_query($dbc, $query);

// Массив для перевода статусов на русский
$status_translation = [
    'created' => 'Создан',
    'in_process' => 'В процессе',
    'accept' => 'Принят',
    'declined' => 'Отклонен'
];

$type_translation = [
    'base' => 'Общий клининг',
    'general' => 'Генеральная уборка',
    'construction' => 'Послестроительная уборка',
    'furniture' => 'Химчистка ковров и мебели',
    'custom' => 'Иная услуга'
];

// Массив для перевода способов оплаты на русский
$payment_translation = [
    'cash' => 'Наличные',
    'card' => 'По карте'
];

?>

<div class="all_orders">
    <?php 
    while ($order = mysqli_fetch_assoc($result)) {

        $status_ru = isset($status_translation[$order['status']]) ? $status_translation[$order['status']] : $order['status'];
        // Переводим тип уборки
        $type_ru = isset($type_translation[$order['type']]) ? $type_translation[$order['type']] : $order['type'];

        // Переводим способ оплаты
        $payment_ru = isset($payment_translation[$order['payment']]) ? $payment_translation[$order['payment']] : $order['payment'];

        $custom_type = !empty($order['custom_type']) ? htmlspecialchars($order['custom_type']) : '';

        $declined_reason = $order['decklined_reason'];

        if (empty($declined_reason)) {
            $declined_reason = '';
            $decline_class  = 'green';
        } else {
            $declined_reason = htmlspecialchars($declined_reason);
            $decline_class  = 'red';
        }

        echo '<div class="order'. ' ' .  $decline_class . '">
                <div class="order__logo">
                    <p><b>Номер заказа:</b> ' . htmlspecialchars($order["id"]) . '</p>
                    <p>' . $status_ru . '</p>
                </div>
                <div class="order_description">
                    <p><b>Адрес:</b> ' . htmlspecialchars($order['adress']) . '</p>
                    <p><b>Тип уборки:</b> ' . $type_ru . '</p>
                    <p><b>Тип оплаты:</b> ' . $payment_ru . '</p>
                    <p><b>Причина отказа:</b> ' . $declined_reason . '</p>';
                
                // Если есть описание для 'custom_type', выводим его
                if ($custom_type) {
                    echo '<p><b>Описание услуги:</b> ' . $custom_type . '</p>';
                }
                echo '</div>
              </div>';
    }
    ?>
</div>
