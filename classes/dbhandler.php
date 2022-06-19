<?php

class DBHandler {
    private settingsPath = "settings.json"
    private $db;
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $pdo;
    
    private function database_settings() {
        $path = "../" . $this->settingsPath;
        if (!file_exists($path)){
            echo "Settings file not found";
            return;
        }
        $myfile = fopen($path), "r") or die("Unable to open file!");
        $data = fread($myfile,filesize($path));
        $jsonData = json_decode($data);
        /*
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->port = $port;
        */
        fclose($myfile);
    }