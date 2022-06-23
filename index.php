<?php

require_once 'init.php';
print_r($_SESSION);
print_r($_POST);

if ($userId !== null) {
    $content = includeTemplate('admin.php', []);
    $title = 'Admin panel';
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    }

    $content = includeTemplate('auth.php', []);
    $title = 'Authorize';
}

$layout = includeTemplate('layout.php', [
    'content' => $content,
    'title' => $title
]);

print($layout);
