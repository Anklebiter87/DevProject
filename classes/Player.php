<?php

class Player extends DBHandler{
    protected $sqlFilePath = "sql/player.json";
    protected $tableName = "Player";
    private $pk;
    private $user;
    private $deck;
    private $hand; 
    private $wins;

    public function set_deck($deck){
        $this->deck = $deck;
    }

    public function get_name(){
        return $this->user->get_name();
    }

    public function get_wins(){
        return $this->wins;
    }

    public function get_player_uid(){
        return $this->user->get_uid();
    }

    public function __construct($user){
        $this->database_setup();
        $this->user = $user;
        $deckId = $user->get_default_deck();
        if($deckId != null){
            $deck = new Deck();
            $deck->get_deck_by_pk($deckId);
            $this->set_deck($deck);
        }
    }
}