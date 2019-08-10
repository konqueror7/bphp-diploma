<?php

if (isset($_GET['state']) && $_GET['state'] !== 'all') {
    $result = $orders->find('state', $_GET['state'])->getObjs(true);
} else {
    $result = $orders->getObjs(true);
}

if (isset($_GET['delete'])) {
    $order = new Order($_GET['delete']);
    $order->delete();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
}

// if (isset($_GET['order'])) {
//     if ($_GET['order'] == 'new' && $_SESSION['role'] == Config::MANAGER_ROLE) {
//         header('Location: http://' . $_SERVER['HTTP_HOST'] . '/edit.php?order='.$_GET['order']);
//     } elseif ($_GET['order'] !== 'new') {
//         if ($_SESSION['role'] == Config::MANAGER_ROLE) {
//               $router = new Router($orders->getGuids());
//         } elseif ($_SESSION['role'] == Config::TRANSLATOR_ROLE) {
//                 $router = new Router($orders->newQuery()->find('name', $_SESSION['name']));
//         }
//         try {
//             $router->isAvailablePage();
//             header('Location: http://' . $_SERVER['HTTP_HOST'] . '/edit.php?order='.$_GET['order']);
//             // echo 'Вы находитесь на странице <b>'.$_GET['order'].'</b>';
//         } catch (Exception $e) {
//             echo $e->getMessage();
//             header('Location: http://' . $_SERVER['HTTP_HOST'] . '/my404.php', 404);
//         }
//     }
// }



?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <title></title>
  </head>
  <body>
    <div class="content">
        <div class="main-menu">
            <div class="main-menu-status-link">
                <ul class="main-menu-status-filters">
                    <li class="main-menu-status-filters-item">
                        <a href="?state=new">New</a>
                    </li>
                    <li class="main-menu-status-filters-item">
                        <a href="?state=resolved">Resolved</a>
                    </li>
                    <li class="main-menu-status-filters-item">
                        <a href="?state=rejected">Rejected</a>
                    </li>
                    <li class="main-menu-status-filters-item">
                        <a href="?state=done">Done</a>
                    </li>
                    <li class="main-menu-status-filters-item">
                        <a href="?state=all">All</a>
                    </li>
                </ul>
            </div>
            <div class="main-menu-action-link">
              <a href="?order=new" class="button">Create new</a>
              <a href="?exit=true" class="main-menu-exit-link">Exit</a>
            </div>
        </div>
        <?php
        print '<div class="announces">';
        foreach ($result as $order => $value) {
            print '<div class="announce">';
            print '<div class="announce-text">';
            foreach ($value->origiLanguage as $lang) {
                print '<p class="announce-text-par">'.$lang.'</p>';
            }
            print '</div>';

            print '<div class="announce-actions-requizite">';
            print '<div class="announce-actions">';
            print '<a href="?order='.$order.'" class="button">Edit</a>';
            print '<a href="?delete='.$order.'" class="button">Delete</a>';
            print '</div>';

            print '<div class="announce-requizite">';
            print '<div class="announce-deadline">'.date('d/m/Y', $value->deadline).'</div>';
            print '<div class="announce-trans-list">';
            foreach ($value->translations as $key => $lang) {
                print '<div class="announce-trans-list-lang">'.$key.'</div>';
            }
            print '</div>';
            print '</div>';
            print '</div>';
            print '</div>';
        }
        print '</div>';
        ?>
    </div>
  </body>
</html>
