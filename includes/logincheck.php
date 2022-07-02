<?php

function authenticated(){
    if(array_key_exists('gamblingtoken', $_SESSION) && array_key_exists('gamblinguid', $_SESSION)){
        return True;
    }
    else{
        return False;
    }
}