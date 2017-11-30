<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';

  createTable('bo_members',
    'user VARCHAR(16),
              pass VARCHAR(16),
              INDEX(user(6))');

createTable('bo_posts',
  'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              date DATETIME,
              post LONGTEXT,
              karma INT UNSIGNED,
              INDEX(auth(6))');

createTable('bo_karma',
  'id INT UNSIGNED,
  ip VARCHAR(50),
  uniq VARCHAR(50),
  INDEX(ip(6))');

/*  createTable('bo_messages',
    'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');

  createTable('bo_friends',
    'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('bo_profiles',
    'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');*/
?>

<br>...done.
</body>
</html>
