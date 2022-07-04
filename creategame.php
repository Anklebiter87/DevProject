<?php
require_once "includes/baseincludes.php";
if(!empty($_POST)){
    $game = new Pazaak();
    if(array_key_exists("joinable", $_POST)){
        $joinable = True;
    }
    else{
        $joinable = False;
    }
    $created = $game->create_new_game($_POST['name'], $user, $joinable);
    if($created){
        header("Location: setup.php?game=" . $game->get_pk());
    }
    else{
        header("Location: index.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Pazaak Create Game</title>
    <?php
    require_once 'includes/head.php';
    ?>
</head>
<div class="row">
    <div class='card'>
        <div class='card-header'>
            <div class="col-12 col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item justify-content-center border">
                        <a href="index.php">
                            <button type="button" class="btn btn-sm btn-secondary">
                                Back To Games
                            </button></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class='card-body'>
            <div class="col-12 col-sm-6 center">
                <form method='POST' id='poster'>
                    <div class="card border border-darker">
                        <div class="card-header">
                            <h3>Create Game</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-sm-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <h4>New Game Name: </h4>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <input type="text" name="name"><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-sm-6">
                                        <h4>Anyone can join:</h4>
                                    </div>
                                    <div class="col-4 col-sm-1 justify-content-start">
                                        <input type="checkbox" id="joinable" name="joinable" value=1 checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="input" value='Save' class="btn btn-sm btn-secondary"
                                title="Tracker">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>