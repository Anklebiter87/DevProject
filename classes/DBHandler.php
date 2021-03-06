<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class DBHandler {
    protected $sqlFilePath;
    protected $tableName;
    protected $settingsPath = "settings.json";

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
        $file = fopen($path, "r") or die("Unable to open file!");
        $data = fread($file,filesize($path));
        $jsonData = json_decode($data);
        $this->host = $jsonData->database->host;
        $this->user = $jsonData->database->user;
        $this->pass = $jsonData->database->password;
        $this->dbname = $jsonData->database->database;
        fclose($file);
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
        $file = fopen($path, "r") or die("Unable to open file!");
        $data = fread($file, filesize($path));
        $jsonData = json_decode($data, true);
        fclose($file);
        return $jsonData;
    }

    private function table_options($jsonData, $key){
        $query = "";
        if (array_key_exists("options", $jsonData[$key])){
            $options = $jsonData[$key]['options'];
            foreach($options as $option){
                $query .= $option.", ";
            }
            return $query;
        }
        if (!array_key_exists('type', $jsonData[$key])){
            throw new Exception("type not found in ($this->tableName) definition");
        }
        $query .= $key . " " .  $jsonData[$key]['type'];
        if($jsonData[$key]['type'] == "varchar"){
            if(array_key_exists('length', $jsonData[$key])){
                $query .= "(" . $jsonData[$key]['length'] . ")";
            }
            else{
                throw new Exception("length not found in ($this->tableName) definition");
            }
            
        }
        if(array_key_exists('null', $jsonData[$key])){
            if(!$jsonData[$key]['null']){
                $query .= " NOT NULL";
            }
        }
        if(array_key_exists('autoincrement', $jsonData[$key])){
            if($jsonData[$key]['autoincrement'] and $jsonData[$key]['type'] == "int"){
                $query .= " AUTO_INCREMENT";
            }
        }
        if(array_key_exists('default', $jsonData[$key])){
            $value = $jsonData[$key]["default"];
            $query .= " DEFAULT $value";
        }
        return $query . ", ";
    }

    private function create_table(){
        if(!isset($this->tableName)){
            throw new Exception("table name is not set");
        }
        $jsonData = $this->get_setting_file();
        $query = "CREATE TABLE $this->tableName (";
        foreach(array_keys($jsonData) as $key){
            $query .= $this->table_options($jsonData, $key);
        }
        $query = rtrim($query, ", ");
        $query .= ");";
        echo $query."\n";
        $this->execute_query($query, array(), array());
    }

    private function check_schema(){
        if (!isset($this->tableName)){
            throw new Exception("Table name not set");
        }
        $query = "describe $this->tableName;";
        $result = $this->execute_query($query, array(), array());
        if($result == Null){
            throw new Exception("Table $this->tableName not found");
        }
        if($result->num_rows > 0){
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $jsonData = $this->get_setting_file();
            $columns = array_keys($jsonData);
            foreach($columns as $column){
                $found  = False;
                foreach($data as $row){
                    if($row['Field'] == $column){
                        $found = True;
                        break;
                    }
                    elseif ($column == "options"){
                        $found = True;
                        break;
                    }
                }
                if (!$found){
                    if($column == 'primary'){
                        continue;
                    }
                    $query = "ALTER TABLE $this->tableName ADD ";
                    $query .= $this->table_options($jsonData, $column);
                    $query = rtrim($query, ", ");
                    $query .= ";";
                    $this->execute_query($query, array(), array());
                }
            }
        }
        else{
            throw new Exception("Table $this->tableName not found");
        }
    }

    private function check_table(){
        if (!isset($this->tableName)){
            throw new Exception("Table name not set");
        }
        $query = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$this->tableName'";
        $result = $this->execute_query($query, array(), array());
        if($result->num_rows == 0){
            $this->create_table();
        }
    }

    protected function database_setup(){
        $this->check_table();
        $this->check_schema();
    }

    public function get_last_insert_id(){
        return $this->conn-> insert_id;
    }

    public function execute_query(string $query, array $argv, array $argvTypes){
        if(!isset($this->conn)){
            $this->connect();
        }
        $stmt = $this->conn->prepare($query);
        if ($stmt == False){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            throw new Exception("Query failed: ($error)");
        }
        if (count($argv) > 0){
            $stmt->bind_param(implode("",$argvTypes), ...$argv);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if($result == False){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
        return $result;
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
        if(isset($this->conn)){
            mysqli_close($this->conn);
        }
        
    }

    public function __destruct(){
        $this->disconnect();
    }

    public function __construct() {
        $this->connect();
    }
}