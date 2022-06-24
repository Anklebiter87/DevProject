<?php
require_once 'includes/autoloader.php';
session_start();
if (isset($_SESSION['gamblingtoken'])) {
    session_destroy();
  header("Location: login.php");
}
?>