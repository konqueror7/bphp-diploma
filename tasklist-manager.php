<?php

/**
 * Фльтрация списка заказов по их состоянию
 */
if (!empty($_GET['state']) && $_GET['state'] !== 'all') {
    $result = $orders->find('state', $_GET['state'])->getObjs(true);
} else {
    $result = $orders->getObjs(true);
}

/**
 * Удаление заказа
 */
if (isset($_GET['delete'])) {
    $order = new Order($_GET['delete']);
    $order->delete();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
}

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
      <!-- Главное меню -->
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
        <!-- Вывод списка заказов -->
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
            print '<a href="?order='.$order.'" class="button button-manager">Edit</a>';
            print '<a href="?delete='.$order.'" class="button button-manager">Delete</a>';
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
