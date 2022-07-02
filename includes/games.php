<?php

class Games{
    private $playableGames;
    private $watchableGames;
    private $wGamesCount;
    private $pGamesCount;
    private $db;
    private $user;

    private function query_for_games($watchable=False){
        $query = "SELECT pk FROM Pazaak where playerOne = ? OR playerTwo = ?";
        $values = array($this->user->get_uid(), $this->user->get_uid());
        $types = array("ii");
        if($watchable){
            $query = "SELECT * FROM Pazaak WHERE watchable = 1";
            $values = array();
            $types = array();
        }
        $results = $this->db->execute_query($query, $values, $types);
        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
                $game = new Pazaak();
                $game->build_from_id($row['pk']);
                if($watchable){
                    $this->watchableGames[] = $game;
                    $this->wGamesCount++;
                }
                else{
                    $this->playableGames[] = $game;
                    $this->pGamesCount++;
                }
            }
        }
    }

    private function load_games(){
        $this->query_for_games();
        $this->query_for_games(True);
    }

    public function get_playable_games(){
        return $this->playableGames;
    }

    public function get_watchable_games(){
        return $this->watchableGames;
    }

    public function get_playable_games_count(){
        return $this->pGamesCount;
    }

    public function get_watchable_games_count(){
        return $this->wGamesCount;
    }

    public function __construct($user){
        $this->db = new DBHandler();
        $this->user = $user;
        $this->wGamesCount = 0;
        $this->pGamesCount = 0;
        $this->playableGames = array();
        $this->watchableGames = array();
        $this->load_games();
    }
}