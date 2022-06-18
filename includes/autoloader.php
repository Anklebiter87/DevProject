<?php

spl_autoload_register('autoLoader');

function autoLoader($className){
    $path = "classes/";
    $extension = ".php";
    $fullpath = $path . $className . $extension;

    if(!file_exists($fullpath)){
        return false;
    }else{
        include_once $fullpath;
    }
}