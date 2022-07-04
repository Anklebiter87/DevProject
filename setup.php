
<?php
require_once 'includes/baseincludes.php';
require_once 'includes/setup.php';
require_once 'includes/decksview.php'

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Pazaak Create Game</title>
    <?php
    require_once 'includes/head.php';
    ?>
    <script src="static/js/gambling/utils.js"></script>
</head>
<body>
<div class="row">
    <div class='card'>
        <div class='card-header'>
            <div class="col-12 col-sm-12">
            <ul class="nav nav-tabs">
                <li class="nav-item justify-content-center border">
                    <a href="index.php">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Pazaak Games
                        </button></a>
                </li>
                <li class="nav-item justify-content-center border">
                    <a target="_blank"
                        href="https://starwars.fandom.com/wiki/Pazaak/Legends#:~:text=Pazaak%2C%20a%20game%20dating%20back,players%20tied%20was%20not%20counted.">
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
            </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
    <div class='card border border-darker'>
            <div class='card-headder'>
                <div class="col-12 col-sm-12">
                    <h3><?php echo $game->get_name()?></h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p>This is the Pazaak game setup screen. Here you have the ability to select
                            what deck you can use in the upcoming game. Your starter deck has already
                            been selected for you. Once you and your opponent have selected a deck,
                            you can begin the game. You can not return to this screen once you decide
                            on your deck, so decide carfully and good luck.</p>
                        </p>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card border border-darker">
                            <div class="card-header">
                                <h3>Game Stats:</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                if($player2 != null){
                                    echo "<h3>Opponent: ";
                                    if($game->is_owner($user)){
                                        echo $player2->get_player_name();
                                    }
                                    else{
                                        echo $player1->get_player_name();
                                    }
                                    echo "</h3>";
                                    if($game->is_ready()){
                                        $pk = $game->get_pk();
                                        echo "<a href=play.php?game=$pk>
                                            <button type=\"button\" class=\"btn btn-sm btn-secondary\">
                                            Play
                                            </button>
                                            </a>";
                                    }
                                    else{
                                        echo "<h3>Status: ";
                                        echo $game->get_state() . "</h3>";
                                    }
                                }
                                else{
                                $game_link = $game->get_game_link();
                                echo "<button type=\"button\" id=\"GameButton\" class=\"btn btn-sm btn-secondary\"
                                    onclick=\"CopyGameLink()\" value=$game_link>
                                    Click to get the link for an Opponent
                                </button>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border border-darker">
            <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card border border-darker">
                                <div class="card-header border border-darker">
                                    <h3>Deck List:</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $decks = new DecksView($user);
                                    $pk = $game->get_pk();
                                    foreach($decks->get_deck_list() as $deck){
                                        if($deck->is_valid()){
                                    ?>
                                    <div class='col-12' style="text-align:left;padding:10px 0;width:100%">
                                        <form method='POST' id='deckdefault'
                                            <?php echo " action='setup.php?game=$pk'";?>>
                                            <input type="hidden" name="deck" value=<?php echo $deck->get_pk()?>>
                                            <button type="submit" class="btn btn-block btn-sm btn-secondary">
                                                <?php 
                                                echo $deck->get_name();
                                                if($playerDeck != null){
                                                    if($deck->get_pk() == $playerDeck->get_pk()){
                                                        echo "<span class=\"badge badge-success\" style=\"color:black\">Selected</span>";
                                                    }
                                                }
                                                ?>
                                            </button>
                                        </form>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-8">
                            <?php
                            if($playerDeck != null){
                                ?>
                            <div class="card border border-darker">
                                <div class="card-header border border-darker">
                                    <h3>Selected Deck: <?php echo $playerDeck->get_name()?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        foreach($playerDeck->get_cards() as $card){
                                            ?>
                                        <div class='col-6 col-sm-4 col-md-3' style="padding:0px;width:100%">
                                            <div class="pazaak-img border border-darker"
                                                data-value=<?php echo $card->get_type_action_str()?>>
                                                <img src=<?php echo $card->get_image_path()?>>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                    else{
                                        echo "<div class='col-12 center' style=\"padding:0px;width:100%\">
                                            <div class=\"pazaak-img border border-darker\">
                                                <h4>No Deck has been selected</h4>
                                            </div>
                                        </div>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
</body>
</html>
