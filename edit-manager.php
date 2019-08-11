<?php
$users = new Users();

/**
 * Если GET-параметр 'order' равен 'new'
 * создается новый заказ
 * иначе извлекаются данные о заказе по его ID
 */
if (isset($_GET['order']) && $_GET['order'] == 'new') {
    $getsOrder = new Order();
} elseif ($_GET['order'] !== 'new') {
    $getsOrder = $orders->getOrder($_GET['order']);
}

/**
 * Сохрарнение заказа очистка $_POST
 * и возврат на страницу списка заказов
 * при использовании кнопки 'Save' ($_POST['submit']) статус заказа 'new'
 * при использовании кнопки 'Done' статус заказа 'done'
 * при использовании кнопки 'Reject' статус заказа 'reject'
 */
if (isset($_POST['submit']) || isset($_POST['state'])) {
    if ($_POST['ordernumber'] !== 'new') {
        $commitsOrder = new Order($_POST['ordernumber']);
    } else {
        $commitsOrder = new Order();
    }
    $commitsOrder->addOrderFromForm();

    $commitsOrder->commit();
    $_POST =[];
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
            <div class="form-group flex-row">
              <a href="?exit=true" class="button button-exit">Exit</a>
            </div>
            <form class="" action="" name="order-manager" method="post">
                <div class="form-group flex-row">
                    <input type="hidden" name="ordernumber" value="<?php print $_GET['order'] ?>">
                    <!-- Выбор ответсвенного за заказ -->
                    <label for="executor" class="label-executor">Ответственный:
                        <select class="select-executor" name="executor" size="1" required>
                            <?php
                            if (isset($getsOrder->executor)) {
                                print '<option selected value="'.$getsOrder->executor.'">';
                                print $getsOrder->executor.' - ';
                                print $users->determineWorkload($orders, $getsOrder->executor).'</option>';
                            } else {
                                print '<option selected disabled value="">Не назначен</option>';
                            }
                            $users->displaySelectList($orders, 'name', $getsOrder->executor);
                            ?>
                        </select>
                    </label>
                    <!-- Ввод названия или имени клиента -->
                    <label for="client" class="label-client"> Клиент
                        <?php
                        if (isset($getsOrder->client)) {
                            print '<input type="text" name="client"';
                            print 'value="'.$getsOrder->client.'" required placeholder="Введите имя клиента">';
                        } else {
                            print '<input type="text" name="client" value=""';
                            print 'required placeholder="Введите имя клиента">';
                        }
                        ?>
                    </label>
                </div>
                      <!-- настройки заказа -->
                      <!-- Выбор языка источника -->
                      <div class="form-group flex-row">
                        <label class="origilanguage-group">
                          <span class="origilanguage-group-label">Язык оригинала:</span>
                          <div class="origilanguage-labels flex-row">
                            <?php
                            foreach (Config::TRANSLATION_LANG as $key) {
                                if (in_array($key, array_keys((array) $getsOrder->origiLanguage))) {
                                    print '<label class="origilanguage">';
                                    print '<input type="radio" name="origilanguage" value="'.$key.'" checked>';
                                    print '<span class="radio-group-label">';
                                    print Orders::expandLangAbbreviation($key);
                                    print '</span>';
                                    print '</label>';
                                } else {
                                    print '<label class="origilanguage">';
                                    print '<input type="radio" name="origilanguage" value="'.$key.'">';
                                    print '<span class="radio-group-label">';
                                    print Orders::expandLangAbbreviation($key).'</span>';
                                    print '</label>';
                                }
                            }
                            ?>
                          </div>
                        </label>
                      </div>
                      <!-- множественный выбор языков перевода -->
                      <div class="form-group flex-row">
                          <label class="translations-group">
                                <span class="translations-group-label">Языки перевода:</span>
                                <div class="translations-labels flex-row">
                                    <?php
                                    foreach (Config::TRANSLATION_LANG as $key) {
                                        if (in_array($key, array_keys((array) $getsOrder->translations))) {
                                            print '<label class="translations">';
                                            print '<input type="checkbox" name="translations[]" value="';
                                            print $key.'" checked>';
                                            print '<span class="check-group-label">';
                                            print Orders::expandLangAbbreviation($key);
                                            print '</span>';
                                            print '</label>';
                                        } else {
                                            print '<label class="translations">';
                                            print '<input type="checkbox" name="translations[]" value="';
                                            print $key.'">';
                                            print '<span class="check-group-label">';
                                            print Orders::expandLangAbbreviation($key);
                                            print '</span>';
                                            print '</label>';
                                        }
                                    }
                                    ?>
                                </div>
                          </label>
                      </div>
                  <!-- Текстовые области для ввода или просмотра текста
                  на языке оригинала с возможностью редактирования -->
                  <div class="form-group flex-row">
                        <?php
                        if (isset($getsOrder->origiLanguage)) {
                            foreach ($getsOrder->origiLanguage as $langKey => $lang) {
                                print '<textarea class="origilanguage-text"';
                                print 'name="origilanguage-text" rows="8" cols="80"';
                                print 'placeholder="Введите текст" required>';
                                print $lang;
                                print '</textarea>';
                            }
                        } else {
                            print '<textarea class="origilanguage-text"';
                            print 'name="origilanguage-text" rows="8" cols="80"';
                            print 'placeholder="Введите текст" required>';
                            print '</textarea>';
                        }
                        ?>
                  </div>
                  <!-- Текстовые области для ввода или просмотра с редактированием
                   переводов на выбранные языки с возможностью редактирования -->
                  <div class="form-group">
                    <?php
                    if (isset($getsOrder->translations)) {
                        foreach ($getsOrder->translations as $transKey => $lang) {
                            print '<label for="translang">';
                            print '<span class="form-group-label">'.$transKey.'</span>';
                            print '<textarea name="'.$transKey.'" class="form-group-textarea">'.$lang.'</textarea>';
                            print '</label>';
                        }
                    }
                    ?>
                  </div>
                  <!-- Кнопки сохранения с изменением статуса заказа -->
                  <div class="form-group flex-row">
                      <div class="status-buttons">
                          <button type="submit" name="state" value="done">Done</button>
                          <button type="submit" name="state" value="reject">Reject</button>
                      </div>
                      <!-- Поле ввода крайнего срока и кнопка сохранения со статусом 'new' -->
                      <div class="deadline-submit">
                          <label class="deadline-label">
                            <span class="deadline-group-label">Крайний срок</span>
                            <?php
                            if (isset($getsOrder->deadline)) {
                                print '<input type="text" name="deadline" value="';
                                print date('d/m/Y', $getsOrder->deadline).'" placeholder="10/12/2019" required>';
                            } else {
                                print '<input type="text" name="deadline" value="" placeholder="10/12/2019" required>';
                            }
                            ?>
                          </label>
                          <input type="submit" name="submit" value="Save">
                      </div>
                  </div>
            </form>
        </div>
    </body>
</html>
