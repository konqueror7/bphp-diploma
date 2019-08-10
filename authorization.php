<?php
require('autoload.php');
require('config/SystemConfig.php');

session_start();

$users = new Users();

//Извлечение массива с объектами по поиску среди свойств
$authorObj = $users->newQuery()->find('email', $_POST['email'])->getObjs(true);
foreach ($authorObj as $key) {
    if ($key->email == $_POST['email']) {
        $author = $key;
    }
}

if ($author->password !== $_POST['password']) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
} else {
    $_SESSION['name'] = $author->name;
    $_SESSION['role'] = $author->role;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
}
// if ($author->role == Config::TRANSLATOR_ROLE) {
//     header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
// } elseif ($author->role == Config::MANAGER_ROLE) {
//     header('Location: http://' . $_SERVER['HTTP_HOST'] . '/manager-job-list.php');
// }
