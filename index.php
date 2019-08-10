<?php
// if ($_POST) {
//     setcookie($email, $_POST['email'], '/');
//     setcookie($email, $_POST['email'], '/');
//     header('Location: http://' . $_SERVER['HTTP_HOST'] . '/bphp-diploma/authorization.php');
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
      <form class="enter-box" action="authorization.php" method="post">
        <input type="text" name="email" value="" placeholder="Enter your email" required>
        <input type="password" name="password" required>
        <input type="submit" name="submit" value="Sign in">
      </form>
    </div>
  </body>
</html>
