<?php
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
unset($_SESSION['username']);
unset($_SESSION['password']);
header('location:login.php?m=success');
exit();
?>