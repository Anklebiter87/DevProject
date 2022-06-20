<?php
    require_once 'includes/autoloader.php';
    $user = new Users();
    $user->query_for_user_by_uid(10);
    echo var_dump($user);