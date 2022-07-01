<?php
    require_once 'includes/autoloader.php';
    require_once 'includes/cardtypes.php';

    $user = new Users();
    $user->build_user_from_database(1201991);
    $address = new ClientAddress();
    $logger = new Logger();
    $swc = new SWC();
    $token = new OAuthToken(null, null, null, 1201991);
    populate_card_types();
    $deck = new Deck();
    $card = new Card();