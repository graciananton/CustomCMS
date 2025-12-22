<?php
  $host_name = 'db5016188832.hosting-data.io';
  $database = 'dbs13175679';
  $user_name = 'dbu246834';
  $password = '78Ijoycian#';

  $link = new mysqli($host_name, $user_name, $password, $database);

  if ($link->connect_error) {
    die('<p>Failed to connect to MySQL: '. $link->connect_error .'</p>');
  } else {
    echo '<p>Connection to MySQL server successfully established.</p>';
  }
?>