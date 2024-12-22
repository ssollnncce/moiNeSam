<?php

// Определение констант для подключения к базе данных
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_HOST = 'localhost:3306';
const DB_NAME = 'cleaning';

// Подключение к базе данных MySQL
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Установка кодировки соединения с базой данных
mysqli_set_charset($dbc, 'utf8');

function escape_data ($data, $dbc) { 

	return mysqli_real_escape_string ($dbc, trim ($data));
	
}
