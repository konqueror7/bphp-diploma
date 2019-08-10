<?php
require('autoload.php');
require('config/SystemConfig.php');
require('config/Router.php');

session_start();

if (!isset($_SESSION['role'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

if (isset($_GET['exit']) && $_GET['exit'] == 'true') {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
}

$orders = new Orders();

// if ($_SESSION['role'] == 'translator') {
if ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
    include('edit-translator.php');
// } elseif ($_SESSION['role'] == 'manager') {
} elseif ($_SESSION['role'] == Config::MANAGER_ROLE) {
    include('edit-manager.php');
}
