<!--* Created by PhpStorm.
* User: Alice Ezhova
* Date: 10/26/2017
* Time: 8:21 PM
-->
<?php
// организация логина
require_once 'functions.php';
$error = $user = $pass = "";

login();

require_once 'header.php';

// если получили данные, записываем их в базу данных
// автор и его пост
if(isset($_POST['author']) || isset($_POST['article'])) {
  $author = $article = "";

  $today = date("Y-m-d H:i:s");
  $author = sanitizeString($_POST['author']);
  $article = sanitizeString($_POST['article']);

// записываем данные в базу данных (все кроме урла)
  $query = "INSERT INTO `bo_posts` (`id`, `auth`, `date`, `post`, `karma`) VALUES (NULL, '$author', '$today', '$article', '0');";
  //$query = "INSERT INTO `bo_posts` (`id`, `auth`, `date`, `post`, `karma`) VALUES (NULL, 'bot', '2017-11-01 04:12:03', 'ххх', '0');";
  queryMysql($query);
}

// End организаця логина


// Выводим последние 5 постов
$page = 0;
if (isset($_GET['p'])) $page = $_GET['p'];
readPage($page);

// исходя из текущей страницы построить листалку - 5 страниц, в середине текущая
echo "&nbsp; ";
for ($p = -2; $p < 4; $p++) {
  if ($page === $p) {
    echo "&nbsp". ($page + 1);
  } elseif ($p + $page > -1) {
    if (checkIfPageExists(($p + $page))) {
      echo "&nbsp;<a href='index.php?p=". ($p + $page) ."'>". ($p + $page + 1) ."</a>";
    }
  }
}
echo "<br><br>";
?>

</body>
</html>

