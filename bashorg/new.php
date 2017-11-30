<?php
/**
 * Created by PhpStorm.
 * User: Alice
 * Date: 10/27/2017
 * Time: 10:37 PM
 */

require_once 'functions.php';
$error = $user = $pass = "";
$loggedIn = false;
login();
if (isset($_SESSION['user'])) $loggedIn = true;
require_once 'header.php';


// отображаем форму ввода новой записи
$today = date("Y-m-d H:i:s");
$localuser = 'bot';
if (isset($_POST['user'])) $localuser = $_POST['user'];
if (isset($_SESSION["user"])) $localuser = $_SESSION["user"];
$pwd = (isset($_SESSION["pass"])) ? $_SESSION["pass"]: $_POST['password'];

if (!$loggedIn) {
  echo "<br><div class='article'> Login or password is not correct</div><br>";
} else {
echo '<!-- форма добавления новой записи-->
<form action="index.php" method="POST">
  <fieldset>
    <input type="hidden" name="author" value="' . $localuser . '">
    <input type="hidden" name="user" value="' . $localuser . '">
    <input type="hidden" name="pass" value="' . $pwd . '">
    <p>Author: ' . $localuser . ' Date: ' . $today . '</p>
    <p>Post</p> <textarea id="article" name="article" cols="55" rows="8"></textarea>
    <br/><br/>
    <input type="submit" value="Publish">
  </fieldset>
  <!--    <input type="reset" value="Cancel">-->
</form>
<!-- End формы добавления новой записи-->';
}
?>
</body>
</html>