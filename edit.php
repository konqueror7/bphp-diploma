<?php
require('autoload.php');
require('config/SystemConfig.php');
require('config/Router.php');

session_start();

/**
 * Возврат на index.php если пользователь не авторизован
 */

if (!isset($_SESSION['role'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

/**
 * Возврат на tasklist.php если пользователь нажал кнопку Exit
 * или перевод на страницу ошибки если $_GET['exit'] пусто
 */
if (isset($_GET['exit']) && $_GET['exit'] == 'true') {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
} elseif (isset($_GET['exit']) && empty($_GET['exit'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
}

/**
 * Перевод на страницу ошибки если адресная строка не содержит никаких GET-параметров
 */
if (empty($_GET['order']) && empty($_GET['exit'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
}

$orders = new Orders();

/**
 * Исключение возможности для обычного переводчика создавать новые заказы или редактировать чужие
 */
if (isset($_GET['order'])) {
    if ($_GET['order'] == 'new' && $_SESSION['role'] !== Config::MANAGER_ROLE) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
    } elseif ($_GET['order'] !== 'new') {
        if ($_SESSION['role'] == Config::MANAGER_ROLE) {
            $router = new Router($orders->getGuids());
        } elseif ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
            $router = new Router($orders->newQuery()->find('executor', $_SESSION['name'])->getGuids());
        }
        try {
            $router->isAvailablePage();
        } catch (Exception $e) {
            echo $e->getMessage();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
        }
    }
}


/**
 * Загрузка страницы реадактора заказа в зависимости от роли пользователя
 */
if ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
    include('edit-translator.php');
} elseif ($_SESSION['role'] == Config::MANAGER_ROLE) {
    include('edit-manager.php');
}
