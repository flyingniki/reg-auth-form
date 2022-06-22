<?php

require_once 'functions.php';
require_once 'config.php';

session_start();
print_r($_SESSION);
print_r($_POST);

if (!empty($_SESSION)) {
    $content = includeTemplate('admin.php', []);
    $title = 'Admin panel';
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = dbConnect($config['db']); // записываем соединение в переменную
        $sql = 
        $result = dbQuery($conn, $sql);
    }

    $content = includeTemplate('auth.php', []);
    $title = 'Authorize';
}

$layout = includeTemplate('layout.php', [
    'content' => $content,
    'title' => $title
]);

print($layout);
