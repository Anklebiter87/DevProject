<?php
require_once 'includes/baseincludes.php';
require_once 'includes/cards.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Pazaak Cards</title>
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
                            <button type="button" class="btn btn-sm btn-secondary" title="Tracker">
                                Pazaak Games
                            </button></a>
                    </li>
                    <li class="nav-item justify-content-center border">
                        <a href="decks.php">
                            <button type="button" class="btn btn-sm btn-secondary" title="Taverns">
                                Decks
                            </button></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class='card-body'>
            <div class="col-12 col-sm-12">
                <div class='card-body'>
                    <div class="card border border-darker" style="height:100%">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="card border border-darker" style="height:100%">
                                        <div class="card-body">
                                            <p>
                                                Welcome to the card overview page. This is where you can see the cards
                                                you have and what cards are in what deck by clicking on the card. The
                                                cards are organized by what has been inported from your inventory and
                                                what has been given to you (IE: Inventory, Auto Generated).
                                                Good luck and have fun in Pazaak!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="card border border-darker" style="height:100%">
                                        <div class="card-body">
                                            <p> To get more cards you have to visit a Pazaak vendor. Pazaak vendors
                                                are located in select Blue Star Dominion Taverns. There is a limited
                                                stock of cards in each tavern, but they do get restocked from time to
                                                time.
                                            </p>
                                            </br>
                                            <h4><u>Pazaak Vendor Locations:</u></h4>
                                            <div class="row">
                                                <div class="col-6 col-sm-4">
                                                    <a href="https://www.swcombine.com/members/cockpit/travel/directed.php?travelClass=0&supplied=1&galX=91&galY=-1&sysX=13&sysY=5&surfX=2&surfY=2&groundX=15&groundY=11" target="_blank">
                                                        <button type="button" class="btn btn-sm btn-secondary">Black
                                                            Onion</button></a>
                                                </div>
                                                <div class="col-6 col-sm-4">
                                                    <a href="https://www.swcombine.com/members/cockpit/travel/directed.php?travelClass=0&supplied=1&galX=370&galY=-230&sysX=16&sysY=10&surfX=3&surfY=1&groundX=10&groundY=18" target="_blank">
                                                        <button type="button" class="btn btn-sm btn-secondary">Outer Rim Cards</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border border-darker">
                        <div class="card-header">
                            <h3>Inventory Cards:</h3>
                            <h4>Total: <?php echo number_format($cards->get_inventory_card_count()); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $counter = 0;
                                foreach ($cards->get_inventory_cards() as $card) {
                                ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="padding:0px">
                                        <div class="card">
                                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target=<?php echo "#collapse-owned-$counter" ?> aria-expanded="false" aria-controls=<?php echo "collapse-owned-$counter" ?>>
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card border border-darker" style="height:100%">
                                                                <div class="card-header center">
                                                                    <h4>Pazaak Card: <?php echo $card->get_type_name(); ?></h4>
                                                                </div>
                                                                <div class="card-body center">
                                                                    <div style="padding:0px" class="pazaak-img border border-darker" data-value="<?php echo $card->get_type_action_str(); ?>">
                                                                        <img src=<?php echo $card->get_image_path(); ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div id=<?php echo "collapse-owned-$counter" ?> class="collapse" aria-labelledby="headingOne">
                                                <div class="card-body">
                                                    <div class="col-12 col-sm-12">
                                                        <p>Uid: <?php echo $card->get_uid(); ?> </p>
                                                    </div>
                                                    <div class="col-12 col-sm-12">
                                                        <?php
                                                        if ($card->get_deck() != null) {
                                                        ?>
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    Assigned Deck
                                                                </div>
                                                                <div class="card-body">
                                                                    <?php
                                                                    $deck = get_deck($card);
                                                                    $number = $deck->get_pk();
                                                                    echo "<a href=deckdetail.php?deck=$number>";
                                                                    ?>
                                                                    <button type="button" class="btn btn-sm btn-secondary">
                                                                        <?php $deck->get_name(); ?>
                                                                    </button></a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <p>Not assigned to a deck</p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
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
                    <div class="card border border-darker">
                        <div class="card-header">
                            <h3>Auto Generated Cards</h3>
                            <h4>Total: <?php echo $cards->get_generated_card_count(); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $counter = 0;
                                foreach ($cards->get_generated_cards() as $card) {
                                ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="padding:0px">
                                        <div class="card">
                                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target=<?php echo "#collapse$counter" ?> aria-expanded="false" aria-controls=<?php echo "collapse$counter" ?>>
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card border border-darker" style="height:100%">
                                                                <div class="card-header center">
                                                                    <h4>Pazaak Card: <?php echo $card->get_type_name(); ?></h4>
                                                                </div>
                                                                <div class="card-body center">
                                                                    <div style="padding:0px" class="pazaak-img border border-darker" data-value=<?php echo $card->get_type_action_str(); ?>>
                                                                        <img src=<?php echo $card->get_image_path(); ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div id=<?php echo "collapse$counter" ?> class="collapse" aria-labelledby="headingOne">
                                                <div class="card-body">
                                                    <div class="col-12 col-sm-12">
                                                        <?php
                                                        if ($card->get_deck()  != null) {
                                                        ?>
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    Assigned Decks
                                                                </div>
                                                                <div class="card-body">
                                                                    <?php
                                                                    $deck = get_deck($card);
                                                                    $number = $deck->get_pk();
                                                                    echo "<a href=deckdetail.php?deck=$number>";
                                                                    ?>
                                                                    <button type="button" class="btn btn-sm btn-secondary">
                                                                        <?php echo $deck->get_name(); ?>
                                                                    </button></a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <p>Not assigned to a deck</p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
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
            </div>
        </div>
    </div>
</body>
</html>