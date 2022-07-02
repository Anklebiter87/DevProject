<?php

require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
if(!authenticated()){
    header("Location: login.php");
}
require_once 'includes/pageglobals.php';