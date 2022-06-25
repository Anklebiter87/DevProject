<?php
    require_once 'includes/autoloader.php';
    $user = new Users();
    $address = new ClientAddress();
    $swc = new Logger();
    $token = new OAuthToken(null, null, null, 1201991);