<?php

// Настройки

// Проверка, находимся ли мы в рабочем режиме
if (!defined('LIVE')) DEFINE('LIVE', false);

// Email для отправки ошибок
const CONTACT_EMAIL = 'you@example.com';

// Константы

// Определение местоположения файлов и URL сайта
const BASE_URI = '/Applications/XAMPP/xamppfiles/htdocs/moinesam/';
const BASE_URL = 'http://localhost/moiNeSam/includes/pages/';
const MYSQL = BASE_URI . 'mysql.inc.php';

// Сессии

// Запуск сессии
session_start();

// Управление ошибками

// Функция для обработки ошибок
function my_error_handler($e_number, $e_message, $e_file, $e_line) {
    // Формирование сообщения об ошибке
    $message = "Произошла ошибка в скрипте '$e_file' на строке $e_line:\n$e_message\n";
    $message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";

    if (!LIVE) {
        // Показ ошибки в браузере
        echo '<div class="alert alert-danger">' . nl2br($message) . '</div>';
    } else {
        // Отправка ошибки на email
        error_log ($message, 1, CONTACT_EMAIL, 'From:admin@example.com');
        if ($e_number != E_NOTICE) {
            echo '<div class="alert alert-danger">Произошла системная ошибка. Приносим извинения за неудобства.</div>';
        }
    }
    return true;
}

set_error_handler('my_error_handler');

// Функция перенаправления

// Функция для перенаправления неавторизованных пользователей
function redirect_invalid_user($check = 'user_id', $destination = 'index.php', $protocol = 'http://') {
    if (!isset($_SESSION[$check])) {
        $url = $protocol . BASE_URL . $destination; // Определение URL
        header("Location: $url");
        exit(); // Завершение скрипта
    }
}
