<?php

class DecksView{
    private $decks;
    private $user;
    private $db;
    private $validCount;

    public function get_deck_list(){
        if($this->decks == null || count($this->decks) == 0){
            $this->build_decks();
        }
        return $this->decks;
    }

    public function valid_count(){
        return $this->validCount;
    }

    public function decks_count(){
        return count($this->decks);
    }

    private function build_decks(){
        $this->decks = [];
        $this->validCount = 0;
        $query = "SELECT pk FROM Deck WHERE characterId = ?;";
        $values = array($this->user->get_uid());
        $types = array("i");
        $results = $this->db->execute_query($query, $values, $types);
        if($results->num_rows > 0){
            $rows = $results->fetch_all(MYSQLI_ASSOC);
            foreach($rows as $row){
                $deck = new Deck();
                $deck->get_deck_by_pk($row["pk"]);
                $this->decks[] = $deck;
                if($deck->is_valid()){
                    $this->validCount++;
                }
            }
        }
    }

    public function __construct($user){
        $this->db = new DBHandler();
        $this->user = $user;
        $this->build_decks();
    }
}