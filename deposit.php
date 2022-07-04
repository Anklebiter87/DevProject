<?php
require_once "includes/baseincludes.php";
if(isset($_POST['amount'])){
    $amount = $_POST['amount'];
}
else{
    $amount = $user->get_gambling_debt();
}
$name = $user->get_name();
$uid = uniqid();
$msg = urlencode("Deposit into $name Credit Line Transaction ID $uid");
$url = "https://www.swcombine.com/members/credits/index.php?senderType=1&receiver=Vadik%20Edik&amount=$amount&communication=$msg";
        
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Pazaak Create Game</title>
    <?php
    require_once 'includes/head.php';
    ?>
<script>
    function checkAmount() {
        var amountSubmit = document.getElementById('amountSubmit').value;
        var url = document.getElementById('url').value;
        var amount = <?php echo $amount; ?>;
        if (amountSubmit == amount) {
            open(url);
        }
    }
</script>
</head>
<div class='card'>
    <div class='card-header'>
        <div class="col-12 col-sm-12">
            <ul class="nav nav-tabs">
                <li class="nav-item justify-content-center border">
                    <a href="index.php">
                        <button type="button" class="btn btn-sm btn-secondary">
                            Back To Pazaak
                        </button></a>
                </li>
            </ul>
        </div>
    </div>
    <div class='card-body'>
        <div class="col-12 col-sm-6 center">
            <div class="card border border-darker">
                <div class="card-header">
                    <h2>Deposit Form:</h2>
                </div>
                <div class="card-body">
                    <div class="col-12 col-sm-12">
                        <form method='POST' id='poster'> 
                            <div class="card border border-darker">
                                <div class="card-header">
                                    <h3> Current Credit Line Amount: <?php echo number_format($user->get_gambling_debt())?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="col-12">
                                            <h3>Amount to Submit To Your Credit Line:</h3>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" value=<?php echo $amount; ?>
                                                id="amountSubmit" name="amount" placeholder="Amount">
                                            <input type="hidden" id="url" name="url" value=<?php echo $url?> hidden>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="input" onclick="checkAmount()" class="btn btn-sm btn-secondary"
                                            title="Tracker">
                                            <?php
                                            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                                echo "Submit New Amount";
                                            }
                                            else{
                                                echo "Submit Amount";
                                            }
                                            ?>
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                                        </body>
                                    </html>
