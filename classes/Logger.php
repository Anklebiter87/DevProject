
<?php

class Logger extends DBHandler{
    protected $sqlFilePath = "sql/logger.json";
    protected $tableName = "Logger";

    public function create_log($swctime, $uid, $address, $message){

        $addrObj = new ClientAddress(null, $address);
        $values = array(time(), $swctime, $uid, $addrObj->get_pk(), $message);
        $types = array("iiiis");
        $query = "INSERT INTO $this->tableName (timestamp, swctime, userId, addressUid, message) ";
        $query .= "VALUES (?, ?, ?, ?, ?);";
        $result = $this->execute_query($query, $values, $types);
        return True;
    }
    
    public function __construct(){
        $this->database_setup();
    }

}