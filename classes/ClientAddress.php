<?php

class ClientAddress extends DBHandler{
    protected $sqlFilePath = "sql/clientaddress.json";
    protected $tableName = "ClientAddress";

    public static function get_client_address($address){

    }

    public function __construct(){
        $this->database_setup();
    }

    public static function get_pk_for_address($address){
        $query = "SELECT uid FROM ClientAddress WHERE address is ?";
    }
}