<?php

spl_autoload_register('autoLoader');

function autoLoader($className){
    if (array_key_exists('HTTP_HOST', $_SERVER)) {
        $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    else{
        $url = NULL;
    }
    
    $extension = ".php";

    if ($url !== NULL){
        if (strpos($url, 'includes') !== false){
            $path = "../classes/";
        }
        else{
            $path = "classes/";
        }
    } 
    else{
        $path = "classes/";
    }
    
    $fullpath = $path . $className . $extension;

    if(!file_exists($fullpath)){
        return false;
    }else{
        require_once $fullpath;
    }
}