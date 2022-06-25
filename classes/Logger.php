
<?php

class Logger extends DBHandler{
    protected $sqlFilePath = "sql/logger.json";
    protected $tableName = "Logger";
    
    public function __construct(){
        $this->database_setup();
    }

}