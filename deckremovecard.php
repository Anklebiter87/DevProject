
<?php
require_once 'includes/baseincludes.php';

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
    $card = $deck->get_card($cardId);
    if($card != null){
        $deck->remove_card($card);
    }
}
if(array_key_exists("deck", $_GET)){
    header("Location: deckdetail.php?deck=" . $_GET["deck"]);
}
else{
    header("Location: decks.php");
}