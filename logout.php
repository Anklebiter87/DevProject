<?php
require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
if(authenticated()){
  session_destroy();
  header("Location: login.php");
}
?>