<?php

include "functions.php";
include "shortUrl.php";

$pdo = connect();

$shortUrl = new ShortUrl($pdo);
try {
  $code = $shortUrl->urlToShortCode($_POST["url"], $_POST['noise']);
  printf('<p><strong>Короткая ссылка:</strong> <a href="%s">%1$s</a></p>',
    SHORTURL_PREFIX . $code);
  exit;
}
catch (Exception $e) {
  // log exception and then redirect to error page.
  //echo "<br/>".$e."<br/>";
  header("Location: error.html");
  exit;
}
?>