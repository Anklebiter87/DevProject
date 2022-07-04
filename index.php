<?php
require_once "includes/baseincludes.php";
require_once "includes/games.php";
$games = new Games($user);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Pazaak</title>
    <?php
    require_once 'includes/head.php';
    ?>
    <script src="static/js/gambling/utils.js"></script>
    <script>
        function hider(id) {
            var elements = document.getElementById("decks-continer").querySelectorAll("#" + id);
            for (var i = 0; i < elements.length; i++) {
                var node = elements[i];
                if (node == null) {
                    return;
                }
                if (node.style.display === "none") {
                    node.style.display = "block";
                } else {
                    node.style.display = "none";
                }
            }
        }
    </script>
</head>
<div class='card'>
    <div class='card-header'>
        <div class="col-12 col-sm-12">
            <ul class="nav nav-tabs">
                <li class="nav-item justify-content-center border">
                    <a target="_blank" href="https://starwars.fandom.com/wiki/Pazaak/Legends#:~:text=Pazaak%2C%20a%20game%20dating%20back,players%20tied%20was%20not%20counted.">
                        <button type="button" class="btn btn-sm btn-secondary">
                            How To Play
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="decks.php">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Decks
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="cards.php">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Cards
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a href="creategame.php">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Create Game
                        </button></a>
                </li>
            </ul>
        </div>
    </div>
    <div class='card-body' id="decks-continer">
        <div class='card border border-darker'>
            <div class='card-headder'>
                <div class="col-12 col-sm-12">
                    <h3>Pazaak:</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p>Welcome to Pazaak! Pazaak is game dating back to Old Republic times, and
                            was a popular card game in which the goal was to come closest to 20
                            without going over. The player with the highest score less than or
                            equal to 20 wins the set, and the player who wins three sets wins
                            the match. A set in which the two players are tied is not counted.
                            If you would like more detail, please click the "How To Play" button above.</p>
                        <br>
                        <p>Because the house needs to keep the lights on, every game you play will cost
                            50,000 credits.
                            All credit lines will bottom out at 
                            <?php echo number_format($user->get_gambling_limit());?>
                            and once you reach that
                            limit you will
                            not be able to play anymore.
                            So, pay your bills and enjoy yoursef.
                        </p>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card border border-darker">
                            <div class="card-header">
                                <h3>Stats:</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-sm-3">
                                        <p>Wins: <?php echo number_format($user->get_total_wins())?></p>
                                        <p>Losses: <?php echo number_format($user->get_total_loses())?></p>
                                    </div>
                                    <div class="col-12 col-sm-9">
                                        <div class="row" style="padding:0px">
                                            <p style="margin: 8px;">&nbsp;&nbsp;Credit Line:&nbsp;</p>
                                            <?php
                                            if($user->get_gambling_debt() <= $user->get_gambling_limit()){
                                                ?>
                                            <a href="deposit.php">
                                                <button type="button" class="btn btn-sm btn-danger">
                                                    <?php echo number_format($user->get_gambling_debt());?>
                                                </button></a>
                                            <p style="color:red">
                                            <?php
                                            }
                                            elseif($user->get_gambling_debt() > $user->get_gambling_limit() && $user->get_gambling_debt() < 0){
                                            ?>
                                                <a href="deposit.php">
                                                    <button type="button" class="btn btn-sm btn-warning">
                                                        <?php echo number_format($user->get_gambling_debt());?>
                                                    </button></a>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <a href="deposit.php">
                                                    <button type="button" class="btn btn-sm btn-secondary">
                                                        <?php echo number_format($user->get_gambling_debt());?>
                                                    </button></a>
                                            <?php }?>
                                        </div>
                                        <p>Total Games Played: <?php echo number_format($user->get_total_games())?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='card border border-darker'>
            <div class='card-header'>
                <div class="col-12 col-sm-12">
                    <h3>Playable Games:</h3>
                </div>
            </div>
            <div class='card-body'>
                <div class="row">
                    <?php
                    $counter = 0;
                    if($games->get_playable_games_count() > 0){

                    foreach($games->get_playable_games() as $game){
                        $player1 = $game->get_player1();
                        $player2 = $game->get_player2();
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border border-darker">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target=<?php echo "#collapse-game-$counter";?> aria-expanded="false" aria-controls=<?php echo "collapse-game-$counter";?> onclick=<?php echo "hider('collapse-game-$counter-hidden')";?>>
                                <div class="card-header">
                                    <u>
                                        <h3>Name: <?php echo $game->get_name()?></h3>
                                    </u>
                                    <div style="display:block" id=<?php echo "collapse-game-$counter-hidden"?>>
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h4>Player 1: <?php echo $player1->get_player_name();?></h4>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <?php 
                                                if($player2 != null){
                                                    echo "<h4>Player 2: ".$player2->get_player_name()."</h4>";
                                                }
                                                else{
                                                    if($game->is_joinable()){
                                                        echo "<h4>Player 2: Waiting for Player 2</h4>";
                                                    }
                                                    else{
                                                        echo "<h4>Player 2: None</h4>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <div id=<?php echo "collapse-game-$counter"?> class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">
                                    <div class="col-12 col-sm-12">
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Players:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Player 1: <?php echo $player1->get_player_name()?></h4>
                                                    </div>
                                                    <div class="col-12 justify-content-center">
                                                        <h5>Wins: <?php echo $player1->get_wins()?></h5>
                                                    </div>
                                                    <div class="col-12">
                                                        <?php
                                                        if($player2 != null){
                                                            echo "<h4>Player 2: ".$player2->get_player_name()."</h4>";
                                                        }
                                                        else{
                                                            if($game->is_owner($user)){
                                                                echo "<p>Player 2 has not joined yet. Use the link to get a game link for another player</p>";
                                                            }
                                                            else{
                                                                echo "<p>Be the first to join! Use the button to get a game link to join.</p>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    if($player2 != null){
                                                        echo "<div class='col-12 justify-content-center'>
                                                            <h5>Wins: ".$player2->get_wins()."</h5>";
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>State:</h4>
                                            </div>
                                            <div class="card-body">
                                                <?php
                                                echo game_state($game);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Links:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3 col-sm-3">
                                                        <?php
                                                        $pk = $game->get_pk();
                                                        if($game->get_state() == "ready"){
                                                            echo "<a href=play.php?game=$pk>
                                                            <button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Play Pazaak\">
                                                                <i class=\"tim-icons icon-controller\"></i>
                                                            </button>
                                                        </a>";
                                                        }
                                                        else{
                                                            echo "<a href=setup.php?game=$pk>
                                                            <button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Setup Pazaak\">
                                                                <i class=\"tim-icons icon-settings-gear-63\"></i>
                                                            </button></a>";
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-3 col-sm-3">
                                                        <?php 
                                                        if($game->is_owner($user)){
                                                            echo "<a href=deletegame.php?game=$pk>
                                                            <button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Delete Pazaak\">
                                                                <i class=\"tim-icons icon-simple-remove\"></i>
                                                            </button></a>";
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-12 col-sm-12">
                                                        <?php
                                                        if($player2 == null){
                                                            if($game->is_owner($user)){
                                                                $game_link = $game->get_game_link();
                                                                echo "<button type=\"button\" id=\"GameButton\" class=\"btn btn-sm btn-secondary\" onclick=\"CopyGameLink()\" value=$game_link>
                                                                    Copy opponent link
                                                                    </button>";
                                                            }
                                                            else{
                                                                echo "<p>Needs another player.</p>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer border border-darker">
                                <div class="col-12 col-sm-12" id=<?php echo "collapse-game-$counter-hidden"?> style="display:block">
                                    <div class="row">
                                        <div class="col-3 col-sm-3">
                                            <?php
                                            $pk = $game->get_pk();
                                            if($game->get_state() == "ready"){
                                                echo "<a href=play.php?game=$pk>";
                                                echo "<button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Play Pazaak\">";
                                                echo "<i class=\"tim-icons icon-controller\"></i>";
                                                echo "</button></a>";
                                            }
                                            else{
                                                echo "<a href=setup.php?game=$pk>";
                                                echo "<button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Setup Pazaak\">";
                                                echo "<i class=\"tim-icons icon-settings-gear-63\"></i>";
                                                echo "</button></a>";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-3 col-sm-3">
                                            <?php
                                            if($game->is_owner($user)){
                                                echo "<a href=deletegame.php?game=$pk>";
                                                echo "<button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Delete Game\">";
                                                echo "<i class=\"tim-icons icon-trash-simple\"></i>";
                                                echo "</button></a>";
                                            }
                                            ?>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <?php
                                            if($player2 == null){
                                                if($game->is_owner($user)){
                                                    $game_link = $game->get_game_link();
                                                    echo "<button type=\"button\" id=\"GameButton\" class=\"btn btn-sm btn-secondary\" onclick=\"CopyGameLink()\" value=$game_link>
                                                        Copy opponent link
                                                        </button>";
                                                }
                                                else{
                                                    echo "<p>Needs another player.</p>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                $counter++;
                }
            }
            else{
                echo "<div class=\"col-12 col-sm-12\">
                        <h4>No games are currently available for you to play.</h4>
                    </div>";
            }
                    ?>
                </div>
            </div>
        </div>
        <div class='card border border-darker'>
            <div class='card-header'>
                <div class="col-12 col-sm-12">
                    <h3>Watchable Games:</h3>
                </div>
            </div>
            <div class='card-body' id="decks-continer">
                <div class="row">
                    <?php
                    $counter = 0;
                    
                    if($games->get_watchable_games_count() > 0){
                        foreach($games->get_watchable_games() as $game){
                            $player1 = $game->get_player1();
                            $player2 = $game->get_player2();
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border border-darker">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target=<?php echo "#collapse-watch-$counter"?> aria-expanded="false" aria-controls=<?php echo "collapse-watch-$counter"?> onclick=<?php echo "hider('collapse-watch-$counter-hidden')"?>>
                                <div class="card-header">
                                    <u>
                                        <h3>Name: <?php echo $game->get_name();?></h3>
                                    </u>
                                    <div style="display:block" id=<?php echo "collapse-game-$counter-hidden"?>>
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h4>Player 1: <?php echo $player1->get_player_name()?></h4>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <?php
                                                if($player2 != null){
                                                    echo "<h4>Player 2: ".$player2->get_player_name()."</h4>";
                                                }
                                                else{
                                                    echo "<h4>Player 2: Waiting for player 2</h4>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <div id=<?php echo "collapse-watch-$counter"?> class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">
                                    <div class="col-12 col-sm-12">
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Players:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Player 1: <?php echo $player1->get_player_name()?></h4>
                                                    </div>
                                                    <div class="col-12 justify-content-center">
                                                        <h5>Wins: <?php echo $player1->get_wins()?></h5>
                                                    </div>
                                                    <div class="col-12">
                                                        <?php
                                                        if($player2 != null){
                                                            echo "<h4>Player 2: ".$player2->get_player_name()."</h4>";
                                                        }
                                                        else{
                                                            if($game->is_joinable()){
                                                                $game_link = $game->get_game_link();
                                                            echo "<a href=$game_link>
                                                                  <button type=\"button\" class=\"btn btn-sm btn-secondary\">
                                                                    Click to join game
                                                                   </button></a>
                                                                   </h4>";
                                                            }
                                                            else{
                                                                echo "<h5>Needs another player.</h5>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                    if($player2 != null){
                                                        echo "<div class=\"col-12 justify-content-center\">
                                                        <h5>Wins: $player2->get_wins()</h5>
                                                        </div>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>State:</h4>
                                            </div>
                                            <div class="card-body">
                                                <?php
                                                echo game_state($game);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card border border-darker">
                                            <div class="card-header">
                                                <h4>Links:</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-12">
                                                    <?php
                                                    $pk = $game->get_pk();
                                                    if($game->get_state() == "ready"){
                                                        echo "<a href=play.php?game=$pk>
                                                        <button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Watch Pazaak\">
                                                            Watch Game
                                                        </button></a>";
                                                    }
                                                    else{
                                                        echo "<h5>A link will be available when the game is ready</h5>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-12 col-sm-12 center" id=<?php echo "collapse-watch-$counter-hidden"?> style="display:block">
                                <?php
                                $pk = $game->get_pk();
                                if($game->get_state() == "ready"){
                                    echo "<a href=play.php?game=$pk>
                                    <button type=\"button\" class=\"btn btn-sm btn-secondary\" title=\"Watch Pazaak\">
                                        Watch Game
                                    </button></a>";
                                }
                                elseif($player2 == null){
                                    if($game->is_joinable()){
                                        $game_link = $game->get_game_link();
                                        echo "<a href=$game_link>
                                              <button type=\"button\" class=\"btn btn-sm btn-secondary\">
                                                Click to join game
                                               </button></a>
                                               </h4>";
                                    }
                                    else{
                                        echo "<h4>A link will be available when the game is ready</h4>";
                                    }
                                }
                                else{
                                    echo "<h4>A link will be available when the game is ready</h4>";
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $counter++;
                }
            }
            else{
                echo "<div class=\"col-12 col-sm-12\">
                        <h4>No games are currently available to watch.</h4>
                    </div>";
            }
            ?>
                </div>
            </div>
        </div>
    </div>
</div>
</html>
