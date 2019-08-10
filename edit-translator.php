<?php

$orders = new Orders();

$order = $orders->getOrder($_GET['order']);

if (isset($_POST['submit'])) {
    foreach ($order->translations as $langAbbr => $langVal) {
        foreach ($_POST as $key => $value) {
            if ($langAbbr == $key) {
                $order->translations->$langAbbr = $value;
            }
        }
    }
    $orders->save();
    $_POST = [];
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/tasklist.php');
} elseif (isset($_POST['state'])) {
    $order->state = $_POST['state'];
    $orders->changeObjByGuid($_POST['ordernumber'], $order);
    $orders->save();
    $_POST = [];
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
      <!-- <p>Редактирование текста заказа</p> -->
        <div class="content">
          <div class="form-group flex-row">
            <a href="?exit=true" class="button button-exit">Exit</a>
          </div>
            <div class="languages-deadline">
                <div class="languages">
                    <div class="languages-item">
                        <p>Язык оригинала<br/>
                            <?php
                            foreach ($order->origiLanguage as $key => $lang) {
                                print '<span class="language-abbreviation">';
                                print Orders::expandLangAbbreviation($key);
                                print '</span>';
                            }
                            ?>
                        </p>
                    </div>

                    <div class="languages-item">
                        <p>Языки перевода<br/>
                            <?php
                            foreach ($order->translations as $key => $lang) {
                                print '<span class="language-abbreviation">';
                                print Orders::expandLangAbbreviation($key);
                                print '</span>';
                            }
                            ?>
                        </p>
                    </div>
                </div>

                <div class="deadline">
                    <p>Крайний срок<br/>
                        <span class=deadline-data>
                            <?php print date('d/m/Y', $order->deadline) ?>
                        </span>
                    </p>
                </div>

            </div>

            <div>
                <form class="" action="" method="post">
                    <input type="hidden" name="ordernumber" value="<?php print $_GET['order'] ?>">
                        <div class="form-group">
                            <?php
                            foreach ($order->origiLanguage as $langKey => $lang) {
                                print '<label for="sourcelang">';
                                print '<textarea name="sourcelang-'.$langKey.'"';
                                print 'class="form-group-textarea" disabled>'.$lang.'</textarea>';
                                print '</label>';
                            }
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                            foreach ($order->translations as $transKey => $lang) {
                                print '<label for="translang">';
                                print '<span class="form-group-label">'.$transKey.'</span>';
                                print '<textarea name="'.$transKey.'" class="form-group-textarea">'.$lang.'</textarea>';
                                print '</label>';
                            }
                            ?>
                        </div>

                        <div class="edit-buttons">
                            <button type="submit" name="state" value="resolved">Resolved</button>
                            <input type="submit" name="submit" value="Save">
                        </div>

                </form>
            </div>
        </div>
    </body>
</html>
