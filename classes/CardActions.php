<?php

class CardActions{
    const action = null;

    public function __construct($action){
        $this->action = $action;
    }

    public function get_action(){
        return $this->action;
    }
}