<?php
    require_once 'includes/autoloader.php';
    $user = new Users();
    $user->build_user_from_database(1201991);
    $address = new ClientAddress();
    $logger = new Logger();
    $swc = new SWC();
    $token = new OAuthToken(null, null, null, 1201991);
