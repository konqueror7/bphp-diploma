<?php
require('autoload.php');
require('config/SystemConfig.php');

session_start();

$users = new Users();

/**
 * Извлечение записи пользователя программы из json-файла по его email
 * @var [type]
 */
$authorObj = $users->newQuery()->find('email', $_POST['email'])->getObjs(true);
foreach ($authorObj as $key) {
    if ($key->email == $_POST['email']) {
        $author = $key;
    }
}

/**
 * Аутентификация и авторизация пользователя и переход на страницу со списком заказов
 * @var [type]
 */
if ($author->password !== $_POST['password']) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
} else {
    $_SESSION['name'] = $author->name;
    $_SESSION['role'] = $author->role;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
}
