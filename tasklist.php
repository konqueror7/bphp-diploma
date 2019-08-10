<?php
require('autoload.php');
require('config/SystemConfig.php');
require('config/Router.php');

session_start();

if (!isset($_SESSION['role'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

if (isset($_GET['exit']) && $_GET['exit'] == 'true') {
    session_destroy();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

$orders = new Orders();

// print '<pre>';
// var_dump($orders->newQuery()->find('executor', $_SESSION['name']));
// print '</pre>';

if (isset($_GET['order'])) {
    if ($_GET['order'] == 'new' && $_SESSION['role'] == Config::MANAGER_ROLE) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/edit.php?order='.$_GET['order']);
    } elseif ($_GET['order'] !== 'new') {
        if ($_SESSION['role'] == Config::MANAGER_ROLE) {
            $router = new Router($orders->getGuids());
        } elseif ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
            $router = new Router($orders->newQuery()->find('executor', $_SESSION['name'])->getGuids());
            // $router = new Router($orders->newQuery()->find('name', $_SESSION['name'])->getGuids());
        }
        try {
            $router->isAvailablePage();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/edit.php?order='.$_GET['order']);
            // echo 'Вы находитесь на странице <b>'.$_GET['order'].'</b>';
        } catch (Exception $e) {
            echo $e->getMessage();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
        }
    }
}

if ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
    require('tasklist-translator.php');
} elseif ($_SESSION['role'] == Config::MANAGER_ROLE) {
    require('tasklist-manager.php');
}
