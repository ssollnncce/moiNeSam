<?php

require '../config/config.inc.php';
require MYSQL;

$title = 'Мои заказы';

include 'header.html';

$uid = $_SESSION['user_id'];

$query = "SELECT id, status, adress, type, payment, custom_type FROM orders ";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем ID заказа и новый статус
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // Проводим валидацию данных
    if (in_array($new_status, ['created', 'in_process', 'accept', 'declined'])) {
        // Обновляем статус заказа в базе данных
        $query = "UPDATE orders SET status = '$new_status' WHERE id = '$order_id'";
        $result = mysqli_query($dbc, $query);

        if ($result) {
            // Перенаправляем обратно на страницу с заказами
            header("Location: admin_panel.php");
            exit;  // Обязательно используйте exit после header для предотвращения дальнейшего выполнения кода
        } else {
            echo "Ошибка обновления статуса. Попробуйте снова.";
        }
    } else {
        echo "Некорректный статус.";
    }
} else {
    echo "Неверный запрос.";
}


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

        echo '<div class="order">
                <div class="order__logo">
                    <p><b>Номер заказа:</b> ' . htmlspecialchars($order["id"]) . '</p>
                    <p>' . $status_ru . '</p>
                </div>
                <div class="order_description">
                    <p><b>Адрес:</b> ' . htmlspecialchars($order['adress']) . '</p>
                    <p><b>Тип уборки:</b> ' . $type_ru . '</p>
                    <p><b>Тип оплаты:</b> ' . $payment_ru . '</p>';
                
                // Если есть описание для 'custom_type', выводим его
                if ($custom_type) {
                    echo '<p><b>Описание услуги:</b> ' . $custom_type . '</p>';
                }
                
                // Форма для изменения статуса
                echo '<form action="admin_panel.php" method="POST">
                        <input type="hidden" name="order_id" value="' . $order['id'] . '">
                        <label for="status">Изменить статус:</label>
                        <select name="status" id="status">
                            <option value="created" ' . ($order['status'] == 'created' ? 'selected' : '') . '>Создан</option>
                            <option value="in_process" ' . ($order['status'] == 'in_process' ? 'selected' : '') . '>В процессе</option>
                            <option value="accept" ' . ($order['status'] == 'accept' ? 'selected' : '') . '>Принят</option>
                            <option value="declined" ' . ($order['status'] == 'declined' ? 'selected' : '') . '>Отклонен</option>
                        </select>
                        <input type="submit" value="Обновить статус">
                    </form>
                </div>
              </div>';
    }
    ?>
</div>