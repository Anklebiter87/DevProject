<?php

require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
if(authenticated()){
  header("Location: index.php");
}
$swc = new SWC();
$scope = array('character_read', "personal_inv_items_read");
$swc->attempt_authorize($scope, false);