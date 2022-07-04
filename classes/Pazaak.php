<?php

class Pazaak extends DBHandler{
    protected $sqlFilePath = "sql/pazaak.json";
    protected $tableName = "Pazaak";
    private $pk;
    private $name;
    private $timestamp;
    private $player1;
    private $player2;
    private $watchable;
    private $joinable;
    private $rounds;
    private $winner;
    private $deleted;
    private $ready;

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

    public function is_watchable(){
        return $this->watchable;
    }

    public function is_joinable(){
        return $this->joinable;
    }

    public function is_ready(){
        return $this->ready;
    }

    public function is_owner($user){
        if($this->player1->get_player_uid() == $user->get_uid()){
            return True;
        }
        else{
            return False;
        }
    }

    public function get_game_hash(){
        $hashstr = $this->pk . $this->name . $this->timestamp . $this->player1->get_pk();
        return md5($hashstr);
    }

    public function get_game_link(){
        $server = $_SERVER["HTTP_HOST"];
        $path = "pazaak/join.php?game=" . $this->pk;
        $hash = "&hash=" . $this->get_game_hash();
        return "http://" . $server . "/" . $path . $hash;
    }

    public function get_winner(){
        return $this->winner;
    }

    public function delete_game(){
        $this->deleted = True;
        $query = "UPDATE Pazaak SET deleted = 1 WHERE pk = ?";
        $values = array($this->pk);
        $types = array("i");
        $this->execute_query($query, $values, $types);
        return $this->deleted;
    }

    private function create_player($user){
        $player = new Player();
        $player->create_new_player($user);
        return $player;
    }

    public function get_state(){
        $message = "";
        if($this->winner != null){
            $message = "finished";
        }
        elseif($this->ready){
            $this->ready = True;
            $message = "ready";
        }
        elseif($this->player2 == null){
            $this->ready = False;
            $message = "needPlayer2";
        }
        elseif($this->player2->get_deck() == null){
            $this->ready = False;
            $message = "needPlayer2Deck";
        }
        elseif($this->player1->get_deck() == null){
            $this->ready = False;
            $message = "needPlayer1Deck";
        }
        return $message;
    }

    public function set_player2($user){
        $this->player2 = $this->create_player($user);
        $query = "UPDATE Pazaak SET player2 = ? WHERE pk = ?";
        $values = array($this->player2->get_pk(), $this->pk);
        $types = array("i", "i");
        $this->execute_query($query, $values, $types);
        $this->get_state();
    }

    public function create_new_game($name, $user, $joinable){
        $this->name = $name;
        $this->player1 = $this->create_player($user); 
        $this->player2 = null;
        $this->watchable = True;
        $this->joinable = $joinable;
        $this->rounds = 0;
        $this->winner = null;
        $this->deleted = False;
        $this->timestamp = time();
 
        $query = "INSERT INTO Pazaak (name, playerOne, playerTwo, watchable, joinable, rounds, winner, deleted, timestamp, ready)";
        $query .= "VALUES (?, ?, NULL, ?, ?, ?, NULL, ?, ?, 0)";
        $values = array($this->name, $this->player1->get_pk(), $this->watchable, $this->joinable, $this->rounds, $this->deleted, $this->timestamp);
        $types = array("s", "i", "i", "i", "i", "i", "i");
        $this->execute_query($query, $values, $types);
        $this->pk = $this->get_last_insert_id();
        return True;
    }

    public function build_from_id($pk){
        $query = "SELECT * FROM Pazaak WHERE pk = ? AND deleted = 0";
        $values = array($pk);
        $types = array("i");
        $result = $this->execute_query($query, $values, $types);
        if($result->num_rows > 0){
            $data = $result->fetch_all(MYSQLI_ASSOC);
            foreach($data as $row){
                $this->pk = $row['pk'];
                $player = new Player();
                $player->build_player($row['playerOne']);
                $this->player1 = $player;
                if($row['playerTwo'] != null){
                    $player = new Player();
                    $player->build_player($row['playerTwo']);
                    $this->player2 = $player;
                }
                $this->name = $row['name'];
                $this->timestamp = $row['timestamp'];
                $this->watchable = $row['watchable'];
                $this->joinable = $row['joinable'];
                $this->rounds = $row['rounds'];
                if($row['winner'] != null){
                    $player = new Player();
                    $player->build_player($row['winner']);
                    $this->winner = $player;
                }
                $this->deleted = $row['deleted'];
            }
        }
    }
        
    public function __construct(){
        $this->database_setup();
    }
}