<?php
require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
authenticated();
require_once 'includes/pageglobals.php';
require_once 'includes/deckdetailview.php';
require_once 'includes/cards.php';
card_check($user);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Pazaak <?php echo $deck->get_name();?> Detail</title>
    <?php
    require_once 'includes/head.php';
    ?>
</head>
<body>
<div class="row mr-12">
    <div class='card'>
        <div class='card-header'>
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item justify-content-center border">
                        <a href="index.php">
                            <button type="button" class="btn btn-sm btn-secondary">
                                Pazaak Games
                            </button></a>
                    </li>
                    <li class="nav-item justify-content-center border">
                        <a href="decks.php">
                            <button type="button" class="btn btn-sm btn-secondary">
                                Pazaak Decks
                            </button></a>
                    </li>
                    <li class="nav-item justify-content-center border">
                        <a href="cards.php">
                            <button type="button" class="btn btn-sm btn-secondary">
                                Cards
                            </button></a>
                    </li>
                    <li class="nav-item justify-content-center border">
                        <a target="_blank"
                            href="https://starwars.fandom.com/wiki/Pazaak/Legends#:~:text=Pazaak%2C%20a%20game%20dating%20back,players%20tied%20was%20not%20counted.">
                            <button type="button" class="btn btn-sm btn-secondary">
                                How To Play
                            </button></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class='card-body'>
            <div class="row">
                <div class="col-8">
                    <div class="card border border-darker" style="height:100%">
                        <div class="card">
                            <div class="card-header">
                                <h3>Pazaak Cards</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php

                                    $cards = card_list($user);
                                    foreach(card_list($user) as $card){
                                    ?>
                                    <div class="col-3">
                                        <div class="card border border-darker" style="height:100%">
                                            <div class="card-header center">
                                                <h4><?php echo $card->get_type_name();?></h4>
                                            </div>
                                            <div class="card-body center">
                                                <div style="padding:0px" class="pazaak-img border border-darker"
                                                    data-value=<?php $card->get_type_action_str();?>>
                                                    <img src="{% static card.cardType.picture %}">
                                                </div>
                                            </div>
                                            <?php 
                                            if($deck->count() < 10){
                                            ?>
                                            <div class="card-footer">
                                                <a href="{% url 'gambling:pazaak-deckaddcard' deck.pk card.pk%}">
                                                    <button type="button" class="btn btn-sm btn-secondary" >
                                                        Add Card
                                                    </button></a>
                                            </div>
                                            <?php
                                            }
                                            ?>
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
                <div class="col-4">
                    <div class="card border border-darker" style="height:100%">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-7">
                                        <h3>Name: <?php echo $deck->get_name();?></h3>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <h4>Deck Count: </h4>
                                            <?php
                                            $message = "";
                                            if($deck->count() < 10){
                                                $message = '<h4 style="color:red">';
                                                $message .= $deck->count();
                                                $message .= '</h4>';
                                            }
                                            else{
                                                $message = '<h4 style="color:green">&nbsp;';
                                                $message .= $deck->count();
                                                $message .= '</h4>';
                                            }
                                            echo $message;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body center">
                                    <div class="row">
                                        <?php
                                        foreach($deck->get_cards() as $card){
                                        ?>
                                        <div class="col-6">
                                            <div class="card border border-darker" style="height:100%">
                                                <div class="card-header center">
                                                    <h4><?php echo $card->get_type_name();?></h4>
                                                </div>
                                                <div class="card-body center">
                                                    <div style="padding:0px" class="pazaak-img border border-darker"
                                                        data-value=<?php echo $card->get_type_action_str();?>>
                                                        <img src=<?php echo $card->get_image_path();?>>
                                                    </div>
                                                </div>
                                                <div class="card-footer center">
                                                    <a href="removecard.php?deck=<?php echo $deck->get_pk()?>&card=<?php echo $card->get_pk()?>">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>