
<?php

class Logger extends DBHandler{
    protected $sqlFilePath = "sql/logger.json";
    protected $tableName = "Logger";
    
    private function database_setup(){
        $this->check_table();
        $this->check_schema();
    }

    public function __construct(){
        $this->database_setup();
    }

}