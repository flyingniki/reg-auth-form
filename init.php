<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('config.php'); // параметры БД
require_once('functions.php');

$conn = dbConnect($config['db']); // записываем соединение в переменную
$userId = getUserIdFromSession(); // получаем ID пользователя из сессии
