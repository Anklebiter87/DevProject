<?php

require_once 'includes/baseincludes.php';

if($_GET){
    if(isset($_GET["game"])){
        $game = new Pazaak();
        $game->build_from_id($_GET["game"]);
        if($game->is_owner($user)){
            $game->delete_game();
        }
    }
    header("Location: index.php");
}