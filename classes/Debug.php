<?php

class Debug{
    /* used to print debug messages to the error server log */
    public static function error_log_print($object = null){
        ob_start();                    
        var_dump( $object );           
        $contents = ob_get_contents(); 
        ob_end_clean();                
        error_log($contents, 0);        
    }
}