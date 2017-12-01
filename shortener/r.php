<?php
include "functions.php";
include "shortUrl.php";

// from the query string using a URL format like
// http://example.com/r?c=X4c where this file is index.php in the
// directory http_root/r/index.php
$code = $_GET["c"];

try {
  $pdo = connect();
}
catch (PDOException $e) {
  trigger_error("Error: Failed to establish connection to database.");
  exit;
}

$shortUrl = new ShortUrl($pdo);
try {
  $url = $shortUrl->shortCodeToUrl($code);
  //echo "<a href='".$url."'>".$code."</a>";
  header("Location: " . $url);
  exit;
}
catch (Exception $e) {
  // log exception and then redirect to error page.
  echo "<br/>".$e."<br/>";
  //header("Location: /error");
  exit;
}
?>