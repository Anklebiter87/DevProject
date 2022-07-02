<?php
require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
authenticated();
require_once 'includes/pageglobals.php';
require_once 'includes/decksview.php';
require_once 'includes/cards.php';
card_check($user);
$decks = new DecksView($user);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Pazaak Deck Manager</title>
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

<body>
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
                        <a target="_blank" href="https://starwars.fandom.com/wiki/Pazaak/Legends#:~:text=Pazaak%2C%20a%20game%20dating%20back,players%20tied%20was%20not%20counted.">
                            <button type="button" class="btn btn-sm btn-secondary">
                                How To Play
                            </button></a>
                    </li>
                    <li class="nav-item justify-content-center border">
                        <a href="createdeck.php">
                            <button type="button" class="btn btn-sm btn-secondary" title="Create Deck">
                                Create Deck
                            </button></a>
                    </li>
                    <li class="nav-item justify-content-center border">
                        <a href="cards.php">
                            <button type="button" class="btn btn-sm btn-secondary" title="Cards">
                                Cards
                            </button></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <div class='card-body'>
                <div class="card border border-darker" style="height:100%">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="card border border-darker" style="height:100%">
                                    <div class="card-body">
                                        <p>
                                            Welcome to the deck manager. This is where you can create or delete
                                            decks. If you click the deck name it will show you all the cards inside of
                                            that deck. You also can quickly remove cards from that view, but for
                                            a deck to be valid and used in games it must have 10 cards. Finally,
                                            you can never delete or modify the starter deck. This is done so you
                                            always have a way to play a game of pazaak.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="card border border-darker" style="height:100%">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <h4>Total Decks: <?php echo $decks->decks_count();?></h4>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <h4>Valid Decks: <?php echo $decks->valid_count();?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php 
                    $counter = 0;
                    foreach($decks->get_deck_list() as $deck){
                    ?>
                    <div class="col-12 col-sm-6">
                        <div class="card border border-darker">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target=<?php echo "#collapse$counter";?> aria-expanded="false" aria-controls=<?php echo "collapse$counter"?>>
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <h3>Name: <?php echo $deck->get_name();?></h3>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <h4>Deck Card Count: </h4>
                                            <?php
                                            $count = $deck->count();
                                            $message = "";
                                            if($count < 10){
                                                $message = '<h4 style="color:red">';
                                                $message.= $count;
                                                $message.= '</h4>';
                                            }
                                            else{
                                                $message = "<h4>$count</h4>";
                                            }
                                            echo $message;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <div id=<?php echo "collapse$counter"?> class="collapse" aria-labelledby="headingOne">
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        foreach($deck->get_cards() as $card){
                                        ?>
                                        <div class="col-6 col-sm-4" style="padding:0px">
                                            <div class="card border border-darker" style="height:100%">
                                                <div class="card-header center">
                                                    <h4><?php echo $card->get_type_name()?>:</h4>
                                                </div>
                                                <div class="card-body center">
                                                    <div style="padding:0px" class="pazaak-img border border-darker" data-value=<?php echo $card->get_type_action_str();?>>
                                                        <img src=<?php echo $card->get_image_path();?>>
                                                    </div>
                                                </div>
                                                <div class="card-footer center">
                                                    <a href="deckremovecard.php?deck=<?php echo $deck->get_pk();?>&card=<?php echo $card->get_pk();?>">
                                                        <button type="button" class="btn btn-sm btn-secondary">
                                                            Remove Card
                                                        </button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="deckdetail.php?deck=<?php echo $deck->get_pk();?>">
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        Edit Deck
                                    </button></a>
                                <a href="deckdelete.php?deck=<?php echo $deck->get_pk();?>">
                                    <button type="button" class="btn btn-sm btn-secondary">
                                        Delete Deck
                                    </button></a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $counter++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>