<?php
define("DB_PDODRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_DATABASE", "test");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "oTcTl1cS");
define("SHORTURL_PREFIX", "http://alice.ezhova.eu/shortener/r.php?c=");

function queryMysql($query) {
  $pdo = connect();
  $result = $pdo->query($query);
  return $result;
}

function connect() {
  try {
    $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST .
      ";dbname=" . DB_DATABASE,
      DB_USERNAME, DB_PASSWORD);
  }
  catch (PDOException $e) {
    echo "Не удалось установить соединение с базой данных";
    exit;
  }

  return $pdo;
}// End function connect()

function sanitizeString($var)
{
  $conn = connect();
  $conn->set_charset('utf8'); // 12.10.17 почему вместо кирилицы вопросы на сервере
  $var = strip_tags($var);
  $var = htmlentities($var);
  $var = stripslashes($var);
  return $conn->real_escape_string($var);
} // End function sanitizeString

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

?>