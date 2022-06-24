<?php

require_once 'init.php';

$userName = $_SESSION['user']['userName'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = getAdminFormData();
    $newUserName = $post['newName'];
    $oldPassword = $post['oldPassword'];
    $newPassword =$post['newPassword'];
    $errors = validateAdminForm();
    foreach ($errors as $key => $value) {
        $classError[$key] = 'form__input--error';
    }
    if (empty($errors)) {        
        $oldPasswordHash = $_SESSION['user']['passwordHash'];
        if (password_verify($oldPassword, $oldPasswordHash)) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            setNewUserName($conn, $userId, $newUserName);
            setNewUserPassword($conn, $userId, $newPasswordHash);
            $_SESSION['user']['userName'] = $newUserName;
            $_SESSION['user']['passwordHash'] = $newPasswordHash;
            header("Location: /admin.php");
            exit();
        } else {
            $classError['oldPassword'] = 'form__input--error';
            $errors['oldPassword'] = 'Неверный пароль';
        }
    }
}

$content = includeTemplate('admin.php', [
    'userName' => $userName,
    'errors' => $errors ?? [],
    'class' => $classError ?? []
]);

$layout = includeTemplate('layout.php', [
    'content' => $content,
    'title' => 'Admin Panel'
]);

print($layout);
