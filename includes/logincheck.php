<?php

function authenticated(){
    if (!isset($_SESSION['gamblingtoken']) || !isset($_SESSION['gamblinguid'])) {
        header("Location: login.php");
    }
    else{
        return True;
    }
}