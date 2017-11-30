<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';

  deleteTable('bo_members');

  deleteTable('bo_messages');

  deleteTable('bo_friends');

  deleteTable('bo_profiles');
?>

<br>...done.
</body>
</html>
