<?php

class Player extends DBHandler{
    protected $sqlFilePath = "sql/player.json";
    protected $tableName = "Player";
    private $pk;
    private $user;
    private $deck;
    private $hand; 
    private $wins;

    public function get_pk(){
        return $this->pk;
    }

    public function set_deck($deck){
        $this->deck = $deck;
    }

    public function get_player_name(){
        return $this->user->get_name();
    }

    public function get_wins(){
        return $this->wins;
    }

    public function get_player_uid(){
        return $this->user->get_uid();
    }

    public function build_player($playerId){
        $query = "SELECT * FROM Player WHERE pk = ?";
        $values = array($playerId);
        $types = array("i");
        $result = $this->execute_query($query, $values, $types);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $user = new Users();
            $user->build_user_from_database($row['characterId']);
            if($row['deck'] != null){
                $deck = new Deck();
                $deck->get_deck_by_pk($row['deck']);
                $this->set_deck($deck);
            }
            $this->pk = $row['pk'];
            $this->user = $user;
            $this->wins = $row['wins'];
        }
    }

    private function save_player(){
        $query = "INSERT INTO Player (characterId, deck, hand, wins) VALUES (?, ?, NULL, ?)";
        if($this->deck != null){
            $deckId = $this->deck->get_pk();
        }else{
            $deckId = null;
        }
        $values = array($this->user->get_uid(), $deckId, $this->wins);
        $types = array("i", "i", "i");
        $this->execute_query($query, $values, $types);
        $this->pk = $this->get_last_insert_id();
    }

    public function create_new_player($user){
        $this->user = $user;
        $this->wins = 0;
        $deckId = $user->get_default_deck();
        if($deckId != null){
            $deck = new Deck();
            $deck->get_deck_by_pk($deckId);
            $this->set_deck($deck);
        }
        else{
            $this->deckId = null;
        }
        $this->save_player();
    }

    public function __construct(){
        $this->database_setup();
    }
}