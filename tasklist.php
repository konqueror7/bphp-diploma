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
 * Возврат на index.php с зваершением сессии если пользователь завершает работу
 * @var [type]
 */
if (isset($_GET['exit']) && $_GET['exit'] == 'true') {
    session_destroy();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

$orders = new Orders();

/**
 * Сортировка заказов по параметру 'deadline'
 */
$orders = $orders->orderBy('deadline');

/**
 * Если $_GET содержит любые другие переменные
 * кроме $_GET['exit'], $_GET['order'], $_GET['state'], $_GET['delete']
 * то сделать редирект на страницу ошибки
 */
if (!empty($_GET) && !isset($_GET['exit'])
&& !isset($_GET['order']) && !isset($_GET['state'])
&& !isset($_GET['delete'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
}

/**
 * Разрешение пользователю только с ролью 'manager' создавать новый заказ,
 * Исключение возможности переводчика редактировать чужие заказы
 */
if (isset($_GET['order'])) {
    if ($_GET['order'] == 'new' && $_SESSION['role'] == Config::MANAGER_ROLE) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/edit.php?order='.$_GET['order']);
    } elseif ($_GET['order'] !== 'new') {
        if ($_SESSION['role'] == Config::MANAGER_ROLE) {
            $router = new Router($orders->getGuids());
        } elseif ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
            $router = new Router($orders->newQuery()->find('executor', $_SESSION['name'])->getGuids());
        }
        try {
            $router->isAvailablePage();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/edit.php?order='.$_GET['order']);
        } catch (Exception $e) {
            echo $e->getMessage();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
        }
    }
}

/**
 * Загрузка страницы списка заказов в зависимости от роли пользователя
 */
if ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
    require('tasklist-translator.php');
} elseif ($_SESSION['role'] == Config::MANAGER_ROLE) {
    require('tasklist-manager.php');
}
