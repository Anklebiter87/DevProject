<?php

class ClientAddress extends DBHandler{
    protected $sqlFilePath = "sql/clientaddress.json";
    protected $tableName = "ClientAddress";

    private $pk;
    private $address;

    private function query_for_object(){
        $results = null;
        if($this->address != null){
            $query = "SELECT * FROM ClientAddress WHERE address = ?;";
            $results = $this->execute_query($query, array($this->address), array("s"));
            if($results->num_rows == 0){
                $insert = "INSERT INTO ClientAddress (address) VALUES (?);";
                $results = $this->execute_query($insert, array($this->address), array("s"));
                $results = $this->execute_query($query, array($this->address), array("s"));
            }
        }
        elseif($this->pk != null){
            $query = "SELECT * FROM ClientAddress WHERE pk = ?";
            $results = $this->execute_query($query, array($this->pk), array("s"));
            if($results->num_rows == 0){
                if($this->address == null){
                    $this->pk = null;
                    return null;
                }
            }
        }
        else{
            return null;
        }
        if($results == null){
            return null;
        }
        $data = $results->fetch_all(MYSQLI_ASSOC);
        $this->pk = $data[0]['pk'];
        $this->address = $data[0]['address'];
    }

    public function get_client_address($address=null){
        if($this->address == null && $address != null){
            $this->address = $address;
            $this->query_for_object();
        }
        return $this->address;
    }

    public function get_pk($pk = null){
        if($this->pk == null && $pk != null){
            $this->pk = $pk;
            $this->query_for_object();
        }
        return $this->pk;
    }

    public function __construct($pk= null, $address = null){
        $this->database_setup();
        if($pk != null){
            $this->pk = $pk;
        }
        if($address != null){
            $this->address = $address;
        }
        $this->query_for_object();
    }


}