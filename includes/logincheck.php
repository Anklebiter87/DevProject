<?php

function authenticated(){
    if(array_key_exists('gamblingtoken', $_SESSION) && array_key_exists('gamblinguid', $_SESSION)){
        if (!isset($_SESSION['gamblingtoken']) || !isset($_SESSION['gamblinguid'])) {
            header("Location: login.php");
        }
        else{
            return True;
        }
    }
    else{
        return False;
    }
}