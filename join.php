<?php
require_once 'includes/baseincludes.php';


if(isset($_GET['game']) && isset($_GET['hash'])){
    $hash = $_GET['hash'];
    $game = new Pazaak();
    $game->build_from_id($_GET['game']);
    if($game->get_player2() == null && $game->get_player1()->get_player_uid() != $user->get_uid()){
        if($hash == $game->get_game_hash()){
            $game->set_player2($user);
            header("Location: setup.php?game=" . $game->get_pk());
        }
        else{
            header("Location: index.php");
        }
        
    }
    else{
        if($game->get_player1()->get_player_uid() == $user->get_uid()){
            header("Location: setup.php?game=" . $game->get_pk());
        }
        else{
            header("Location: index.php");
        }
        
    }
}
else{
    header("Location: index.php");
}