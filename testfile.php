<?php
    require_once 'includes/autoloader.php';
    $swc = new SWC();
    $scope = array('character_read');
    $swc->attempt_authorize($scope, false);