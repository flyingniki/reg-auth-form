<?php

require_once 'functions.php';
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = dbConnect($config['db']); // записываем соединение в переменную
    $post = filterArray($_POST);
    addUsers($conn, $post);
    header("Location: /index.php");
    exit();
}

$content = includeTemplate('register.php', []);
$title = 'Register';

$layout = includeTemplate('layout.php', [
    'content' => $content,
    'title' => $title
]);

print($layout);
