<?php
require_once 'includes/autoloader.php';
session_start();
if(authenticated()){
  session_destroy();
  header("Location: login.php");
}
?>