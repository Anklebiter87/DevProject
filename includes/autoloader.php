<?php

spl_autoload_register('autoLoader');

function autoLoader($className){
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $extension = ".php";
    if (strpos($url, 'includes') !== false){
        $path = "../classes/";
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