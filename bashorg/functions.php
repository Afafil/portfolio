<?php
/**
 * Created by PhpStorm.
 * User: Alice
 * Date: 10/26/2017
 * Time: 8:46 PM
 */
$appname = "bash.im - Цитатник Рунета";

  function createTable($name, $query) {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Таблица '$name' создана или уже существовала<br>";
  }

  function deleteTable($name) {
    $conn = connect();
    $conn->query("DROP TABLE $name");
    $conn->close();
    echo "Таблица '$name' удалена<br>";
  }

  function queryMysql($query) {
    $conn = connect();
    $result = mysqli_query($conn, $query);
    if (!$result) die($conn->error);
  //  $conn->close();
    return $result;
  }

  function connect() {
  // подключаемся к базе данных
    $hn = 'localhost';
    $db = 'test';
    $un = 'root';
    $pw = 'oTcTl1cS';

    $conn = mysqli_connect($hn, $un, $pw, $db);
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    };

    return $conn;
  }// End function connect()

function Redirect($target, $permanent = false)
{
  if (headers_sent() === false)
  {
    $url = 'http://' . $_SERVER['HTTP_HOST'];            // Get the server
    $url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); // Get the current directory
    $url .= $target;            // <-- Your relative path

    header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
  }

  exit();
} // End Redirect

function destroySession()
{
  $_SESSION=array();

  if (session_id() != "" || isset($_COOKIE[session_name()]))
    setcookie(session_name(), '', time()-2592000, '/');

  session_destroy();
}// End function destroySession

function sanitizeString($var)
{
  $conn = connect();
  $conn->set_charset('utf8'); // 12.10.17 почему вместо кирилицы вопросы на сервере
  $var = strip_tags($var);
  $var = htmlentities($var);
  $var = stripslashes($var);
  return $conn->real_escape_string($var);
} // End function sanitizeString

function login() {
  session_start();
// если получили данные логин-пароля, открываем сессию
  if (isset($_POST['user'])){
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br>";
    else {
      $result = queryMySQL("SELECT user,pass FROM bo_members
      WHERE user='$user' AND pass='$pass'");

      if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Username/Password
                  invalid</span><br><br>";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
      }
    }
  }
}


function showProfile($user)
{
  if (file_exists("$user.jpg"))
    echo "<img src='$user.jpg' style='float:left;'>";

  $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

  if ($result->num_rows)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
  }
} //End function showProfile

function readPage($page = 0) {
  $result = queryMysql("SELECT * FROM bo_posts ORDER BY id DESC LIMIT ". ($page * 5) .", 5;");

  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<div class='info'> &nbsp;&nbsp;<a href='#' onclick='changeKarma(". $row['id'] .", 1)'>+</a>
      &nbsp;&nbsp;&nbsp;<span id='karma". $row['id'] ."'> ". $row['karma'] . "</span>" .
      " &nbsp;&nbsp;&nbsp;<a href='#' onclick='changeKarma(". $row['id'] .", -1)'>-</a> &nbsp;&nbsp;&nbsp; Author: ".
      $row['auth'] ." &nbsp;&nbsp; ". $row['date'] .
      "<span class='floatedRight'>#". $row['id'] ." &nbsp;&nbsp;&nbsp;</span></div>";
    echo "<div class='article'>". $row['post'] ."</div><br><br>";
  }
  mysqli_free_result($result);
} // End readPage


function checkIfPageExists($page) {
  $result = queryMysql("SELECT * FROM bo_posts ORDER BY id DESC LIMIT ". ($page * 5) .", 5;");
  $exist = true;
  if ($result->num_rows == 0) $exist = false;
  mysqli_free_result($result);
  return $exist;
}

function getRealIpAddr() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else {
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

function UniqueMachineID($salt = "") {
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
    if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
    $output = shell_exec("diskpart /s ".$temp);
    $lines = explode("\n",$output);
    $result = array_filter($lines,function($line) {
      return stripos($line,"ID:")!==false;
    });
    if(count($result)>0) {
      $result = array_shift(array_values($result));
      $result = explode(":",$result);
      $result = trim(end($result));
    } else $result = $output;
  } else {
    $result = shell_exec("blkid -o value -s UUID");
    if(stripos($result,"blkid")!==false) {
      $result = $_SERVER['HTTP_HOST'];
    }
  }
  return md5($salt.md5($result));
}

?>