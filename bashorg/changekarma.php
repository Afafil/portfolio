<?php // changekarma.php call from javascript.js - ajxRequest() - changeKarma()
require_once 'functions.php';

if (isset($_GET['idArticle'])) {
  $ip = getRealIpAddr();
  $uniq = UniqueMachineID();
  $idArticle = $_GET['idArticle'];
  $change = $_GET['m'];
  $karma = 0;
  //echo "SELECT karma FROM bo_posts WHERE id='". $idArticle . "'";
  $result = queryMysql("SELECT karma FROM bo_posts WHERE id='". $idArticle . "'");
  if ($rowp = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    //echo "<br>done.<br>";
    $karma = $rowp['karma'] + $change;

    // check if already range this post
    //echo "SELECT * FROM bo_karma WHERE id='". $idArticle . "' AND ip='". $ip ."' AND uniq='". $uniq ."'";
    $result = queryMysql("SELECT * FROM bo_karma WHERE id='". $idArticle . "' AND ip='". $ip ."' AND uniq='". $uniq ."'");
    if ($rowk = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      //echo "<br>done.<br>";
      echo $rowp['karma'];
      die();
    }

    //if ($karma > 0) {
    //echo "UPDATE bo_posts SET karma='" . $karma . "' WHERE id='" . $idArticle . "'";
    $result = queryMysql("UPDATE bo_posts SET karma='" . $karma . "' WHERE id='" . $idArticle . "'");
    //echo "<br>done.<br>";
    //echo "INSERT INTO `bo_karma` (`id`, `ip`, `uniq`) VALUES ('$idArticle', '$ip', '$uniq'";
    $result = queryMysql("INSERT INTO `bo_karma` (`id`, `ip`, `uniq`) VALUES ('$idArticle', '$ip', '$uniq');");
    //echo "<br>done.<br>";
      mysqli_free_result($result);
    //}
  }
  echo $karma;
}
?>