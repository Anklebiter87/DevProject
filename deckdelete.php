<?php

require_once 'includes/baseincludes.php';

if($_GET){
    if(isset($_GET["deck"])){
        $deck = new Deck();
        $imported = $deck->get_deck_by_pk($_GET["deck"]);
        if($imported){
            if($deck->get_owner()->get_uid() == $user->get_uid()){
                $deck->delete_deck();
            }
        }
    }
    header("Location: decks.php");
}