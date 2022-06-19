
<?php
require_once "DBHandler.php";

class Users extends DBHandler{
    protected $sqlFilePath = "sql/users.json";
    protected $tableName = "Users";
    
    private function database_setup(){
        $this->check_table();
        $this->check_schema();
    }

    public function __construct(){
        $this->database_setup();
    }
}