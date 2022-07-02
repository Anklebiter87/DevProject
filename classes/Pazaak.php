<?php

class Pazaak extends DBHandler{
    protected $sqlFilePath = "sql/pazaak.json";
    protected $tableName = "Pazaak";
    private $pk;
    private $name;
    private $timestamp;
    private $swctime;
    private $player1;
    private $player2;
    private $watchable;
    private $joinable;
    private $rounds;
    private $winner;

    public function get_rounds(){
        return $this->rounds;
    }

    public function get_player1(){
        return $this->player1;
    }

    public function get_player2(){
        return $this->player2;
    }

    public function get_pk(){
        return $this->pk;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_watchable(){
        return $this->watchable;
    }

    public function get_joinable(){
        return $this->joinable;
    }

    public function is_owner($user){
        if($this->player1->get_player_uid() == $user->get_uid()){
            return True;
        }
        else{
            return False;
        }
    }

    public function get_winner(){
        return $this->winner;
    }

    public function build_from_id($pk){
        $query = "SELECT * FROM games WHERE pk = ?";
        $values = array($pk);
        $types = array("i");
        $result = $this->execute_query($query, $values, $types);
        if($result->num_rows > 0){
            $data = $result->fetch_all(MYSQLI_ASSOC);
            foreach($data as $row){
                $this->pk = $row['pk'];
                $this->player1 = $row['playerOne'];
                $this->player2 = $row['playerTwo'];
                $this->name = $row['name'];
                $this->timestamp = $row['timestamp'];
                $this->swctime = $row['swctime'];
                $this->watchable = $row['watchable'];
                $this->joinable = $row['joinable'];
            }
        }
    }
        
    public function __construct(){
        $this->database_setup();
    }
}