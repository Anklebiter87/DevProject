<?php

require_once 'includes/autoloader.php';
session_start();
if (isset($_SESSION['gamblingtoken'])) {
  header("Location: index.php");
}

$swc = new SWC();
$scope = array('character_read');
$swc->attempt_authorize($scope, false);