<?php

require_once 'init.php';

$userName = $_SESSION['user']['userName'];
$userId = $_SESSION['user']['userId'];
$hash = $_SESSION['user']['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = filterArray($_POST);
    $query = "SELECT * FROM users u WHERE id='$userId'";

    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $newUserName = $post['new-name'];
    $oldPassword = $post['old-password'];
    $newPassword = $post['new-password'];

    // Проверяем соответствие хеша из базы введенному старому паролю
    if (password_verify($oldPassword, $hash)) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users u SET `password`='$newPasswordHash' WHERE `id`='$userId'";

        mysqli_query($conn, $query);
    } else {
        $error = 'Неверный пароль';
    }
}

$content = includeTemplate('admin.php', [
    'userName' => $userName,
    'error' => $error ?? null
]);

$layout = includeTemplate('layout.php', [
    'content' => $content,
    'title' => 'Admin Panel'
]);

print($layout);
