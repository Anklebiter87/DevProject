<?php
require_once 'includes/autoloader.php';
require_once 'includes/logincheck.php';
session_start();
authenticated();
require_once 'includes/pageglobals.php';
require_once 'includes/decksview.php';
if($_POST){
    $deck = new Deck();
    $deck->create_new_deck($_POST['name'], $user);
    header("Location: decks.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Create Pazaak Game</title>
    <?php
    require_once 'includes/head.php';
    ?>
</head>
<body>
    <div class='card'>
        <div class='card-header'>
            <div class="col-12 col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item justify-content-center border">
                        <a href="decks.php">
                            <button type="button" class="btn btn-sm btn-secondary">
                                Back To Deck Manager
                            </button></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="col-12 col-sm-6 center">
                <div class="card border border-darker">
                    <form method='POST' id='poster'>
                        <div class="card-header">
                            <h3>Create Deck</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-sm-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <h4>New Deck Name: </h4>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <input type="text" name="name"><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="input" value='Save' class="btn btn-sm btn-secondary">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</body>