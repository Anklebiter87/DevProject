<?php

function game_state($game){
    $message = "<p>";
    if($game->get_state() == "needPlayer2"){
        $message .= "Waiting for Player 2";
    }
    elseif ($game->get_state() == "inProgress"){
        $message .= "Current game is playing";
    }
    elseif ($game->get_state() == "finished"){
        if($game->get_winner() != null){
            $message .= $game->get_winner()->get_name(). "won the last round";
        }
    }
    $message .= "</p>";
    $message .= "<p>Rounds Played: ". $game->get_rounds(). "</p>";
    return $message;
}

class Games{
    private $playableGames;
    private $watchableGames;
    private $wGamesCount;
    private $pGamesCount;
    private $db;
    private $user;

    private function query_for_games($watchable=False){
        if($watchable){
            $query = "SELECT G.* from Pazaak as G ";
            $query .= "INNER Join Player as P on G.playerOne=P.pk ";
            $query .= "INNER JOIN Users as U on U.uid=P.characterId ";
            $query .= "WHERE P.characterId = U.uid AND ";
            $query .= "watchable = 1 AND deleted = 0 AND ";
            $query .= "(P.characterId != ? OR P.characterId != ?)";
        }
        else{
            $query = "SELECT G.* from Pazaak as G ";
            $query .= "INNER Join Player as P on G.playerOne=P.pk ";
            $query .= "INNER JOIN Users as U on U.uid=P.characterId ";
            $query .= "WHERE P.characterId = U.uid AND ";
            $query .= "deleted = 0 AND ";
            $query .= "(P.characterId = ? OR P.characterId = ?)";
        }
        $values = array($this->user->get_uid(), $this->user->get_uid());
        $types = array("ii");
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