<?php
include "functions.php";
include "shortUrl.php";

// How are you getting your short code?

// from framework or front controller using a URL format like
// http://.example.com/r/X4c
// $code = $uri_data[1];

// from the query string using a URL format like
// http://example.com/r?c=X4c where this file is index.php in the
// directory http_root/r/index.php
$code = $_GET["c"];

try {
  $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST .
    ";dbname=" . DB_DATABASE,
    DB_USERNAME, DB_PASSWORD);
}
catch (PDOException $e) {
  trigger_error("Error: Failed to establish connection to database.");
  exit;
}

$shortUrl = new ShortUrl($pdo);
try {
  $url = $shortUrl->shortCodeToUrl($code);
  header("Location: " . $url);
  exit;
}
catch (Exception $e) {
  // log exception and then redirect to error page.
  header("Location: /error");
  exit;
}
?>