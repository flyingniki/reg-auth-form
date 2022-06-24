<?php

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = getUsers($conn);
    $post = getRegisterFormData();
    $errors = validateRegisterForm($users);

    foreach ($errors as $key => $value) {
        $classError[$key] = 'form__input--error';
    }
    if (empty($errors)) {
        addUsers($conn, $post);
        $_SESSION['user']['userId'] = $user['id'];
        $_SESSION['user']['userName'] = $user['name'];
        $_SESSION['user']['passwordHash'] = $user['password'];
        header("Location: /admin.php");
        exit();
    }
}

$content = includeTemplate('register.php', [
    'post' => $post ?? [],
    'class' => $classError ?? [],
    'errors' => $errors ?? []
]);

$layout = includeTemplate('layout.php', [
    'content' => $content,
    'title' => 'Register'
]);

print($layout);
