<?php

/**
 * Фльтрация списка заказов по их состоянию
 */
if (!empty($_GET['state']) && $_GET['state'] !== 'all') {
    $result = $orders->find('executor', $_SESSION['name'])->find('state', $_GET['state'])->getObjs(true);
} else {
    $result = $orders->find('executor', $_SESSION['name'])->getObjs(true);
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
            <a href="?exit=true" class="main-menu-exit-link">Exit</a>
        </div>
        <!-- Вывод списка заказов -->
        <?php
        print '<div class="announces">';
        foreach ($result as $order => $value) {
            // print '<div>'.$order.' '.$value->executor.'</div>';
            // print '<div>'.$value->deadline.'</div>';
            print '<div class="announce">';
            print '<a href="?order='.$order.'" class="announce-link">';
            print '<div class="announce-requizite">';
            print '<div class="announce-deadline">'.date('d/m/Y', $value->deadline).'</div>';
            print '<div class="announce-trans-list">';
            foreach ($value->translations as $key => $lang) {
                print '<div class="announce-trans-list-lang">'.$key.'</div>';
            }
            print '</div>';
            print '</div>';

            foreach ($value->origiLanguage as $lang) {
                print '<p class="announce-text-par">'.$lang.'</p>';
            }
            print '</a>';
            print '</div>';
        }
        print '</div>';
        ?>
    </div>
  </body>
</html>
