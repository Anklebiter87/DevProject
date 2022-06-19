<?php

class DBHandler {
    protected $sqlFilePath;
    protected $tableName;

    private $settingsPath = "settings.json";
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;
    
    private function database_settings() {
        $path = "../" . $this->settingsPath;
        
        if (!file_exists($path)){
            $path = $this->settingsPath;
            if (!file_exists($path)){
                throw new Exception("Settings file not found");
            }
        }
        $myfile = fopen($path, "r") or die("Unable to open file!");
        $data = fread($myfile,filesize($path));
        $jsonData = json_decode($data);
        $this->host = $jsonData->database->host;
        $this->user = $jsonData->database->user;
        $this->pass = $jsonData->database->password;
        $this->dbname = $jsonData->database->database;
        fclose($myfile);
    }

    private function get_setting_file(){
        if(!isset($this->sqlFilePath)){
            throw new Exception("SQL file not set");
        }
        $path = $this->sqlFilePath;
        if (!file_exists($path)){
            $path = "../" . $this->sqlFilePath;
            if (!file_exists($path)){
                throw new Exception("SQL file not found");
            }
        }
        return $path;
    }

    protected function check_schema(){
        if (!isset($this->tableName)){
            throw new Exception("Table name not set");
        }
        $query = "SELECT * from INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='($this->tableName)';";
    }

    protected function check_table(){
        if (!isset($this->tableName)){
            throw new Exception("Table name not set");
        }
        $query = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '($this->tableName)'";
        $result = $this->execute_query($query, array());
        echo var_dump($result);
        if(count($result) == 0){
            $this->create_table();
        }
    }

    public function execute_query(string $query, array $argv){
        if(!isset($this->conn)){
            $this->connect();
        }
        $stmt = $this->conn->prepare($query);
        if (count($argv) > 0){
            $stmt->bind_param('is', ...$argv);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function connect(){
        $this->database_settings();
        try{
            $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        } catch (mysqli_sql_exception $e){
            throw new Exception("Error connecting to database");
        }
    }

    private function disconnect(){
        mysqli_close($this->conn);
    }

    public function __destruct(){
        $this->disconnect();
    }

    public function __construct() {
        $this->connect();
    }
}