<?php

if($_GET){
    if(isset($_GET["deck"])){
        $deck = new Deck();
        $set = $deck->get_deck_by_pk($_GET["deck"]);
        if(!$set){
            header("Location: decks.php");
        }

    }
}