<?php
/**
 * Created by PhpStorm.
 * User: Alice
 * Date: 10/26/2017
 * Time: 8:47 PM
 */
session_start();

echo "<!DOCTYPE html>\n<html><head>";

require_once 'functions.php';
header('Content-Type: text/html; charset=utf-8'); // 12.10.17 почему вместо кирилицы вопросы на сервере

$userstr = ' (Guest)';
if (isset($_SESSION['user']))
{
  $user     = $_SESSION['user'];
  $loggedin = TRUE;
  $userstr  = " ($user)";
}
else $loggedin = FALSE;

echo "<title>$appname$userstr</title><link rel='stylesheet' " .
  "href='styles.css' type='text/css'>"                     .
  "</head><body><div id='logo'>&nbsp;</div>"             .
  "<div class='appname'>$userstr</div>"            .
  "<script src='javascript.js'></script>";

if (!$loggedin) {
  echo "<div class='main'><br>";

  echo <<<_END
    <form method='post' action='new.php' class="floatedRight">$error
    <span><b>Log in:</b> Username</span>
    <input type='text' maxlength='16' name='user' value='$user' size="8">
    <span>Password</span>
    <input type='password' maxlength='16' name='pass' value='$pass' size="8">
    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Login'>
    </form></div>
_END;
}

if ($loggedin)
{
  echo "<ul class='menu floatedLeft'>" .
    "<li><a href='index.php'>Home</a></li>"       .
    "<li><a href='new.php'>Add new</a></li>"       .
    "<li><a href='logout.php'>Log out</a></li></ul><br>";
}
else
{
  echo ("<ul class='menu floatedLeft'>" .
    "<li><a href='index.php'>Home</a></li>"                .
    "<li><a href='signup.php'>Sign up</a></li></ul>");
}

echo "<div class='clearBoth'>&nbsp;</div>";
//echo "<p class='testing'>session.user: ". $_SESSION['user'] ."</p>";
?>