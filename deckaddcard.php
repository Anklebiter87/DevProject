
<?php
require_once 'includes/baseincludes.php';

if(array_key_exists("deck", $_GET) && array_key_exists("card", $_GET)){
    if(isset($_GET["deck"]) && isset($_GET["card"])){
        $deckId = $_GET["deck"];
        $cardId = $_GET["card"];
        $deck = new Deck();
        $set = $deck->get_deck_by_pk($deckId);
        if(!$set){
            header("Location: decks.php");
        }
        if($deck->get_owner()->get_uid() != $user->get_uid()){
            header("Location: decks.php");
        }
        $card = new Card();
        $card->set_card_from_database($cardId, $user);
        if($card != null){
            $deck->add_card($card);
        }
    }
}
if(array_key_exists("deck", $_GET)){
    header("Location: deckdetail.php?deck=" . $_GET["deck"]);
}
else{
    header("Location: decks.php");
}