
<?php

class Users extends DBHandler{
    protected $sqlFilePath = "sql/users.json";
    protected $tableName = "Users";
    private $username;
    private $uid;
    
    private function database_setup(){
        $this->check_table();
        $this->check_schema();
    }

    public function query_for_user_by_name(string $username){
        $query = "SELECT * FROM $this->tableName WHERE username like ?";
        $result = $this->execute_query($query, array($username), array("s"));
        if ($result->num_rows == 0){
            return False;
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach($data as $row){
            $this->username = $row['username'];
            $this->uid = $row['uid'];
        }
        return True;
    }

    public function query_for_user_by_uid(int $uid){
        $query = "SELECT * FROM $this->tableName WHERE uid = ?";
        $result = $this->execute_query($query, array($uid), array("i"));
        if ($result->num_rows == 0){
            return False;
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach($data as $row){
            $this->username = $row['username'];
            $this->uid = $row['uid'];
        }
        return True;
    }

    public function get_username(){
        return $this->username;
    }

    public function get_uid(){
        return $this->uid;
    }

    public function __construct(){
        $this->database_setup();
    }
}