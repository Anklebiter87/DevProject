<?php
if(!empty($_POST)){
    if(isset($_GET['game'])){
        $setup = new Setup($_GET["game"], $user);
        $pk = $setup->get_game_pk();
        $player = $setup->get_player();
        if($player == null){
            header("Location: index.php");
        }
        if(isset($_POST['deck'])){
            $deck = new Deck();
            $deck->get_deck_by_pk($_POST["deck"]);
            $player->set_deck($deck);
        }
        header("Location: setup.php?game=$pk");
    }
    else{
        Debug::error_log_print("No game pk found in setup.php");
        header("Location: index.php");
    }
    exit();
}
elseif(!empty($_GET)){
    if(isset($_GET["game"])){
        $setup = new Setup($_GET["game"], $user);
        $game = new Pazaak();
        $game->build_from_id($_GET["game"]);
        if(!$setup->check_if_player()){
            header("Location: index.php");
        }
        $player1 = $game->get_player1();
        $player2 = $game->get_player2();
        $playerDeck = $setup->get_player_deck();
    }
    else{
        header("Location: index.php");
    }
    
}
else{
    Debug::error_log_print("Cookies");
}

class Setup{
    private $game;
    private $user;

    public function get_game_pk(){
        return $this->game->get_pk();
    }

    public function get_player_deck(){
        $player2 = $this->game->get_player2();
        $player1 = $this->game->get_player1();
        if($player2 != null){
            if($player2->get_player_uid() == $this->user->get_uid()){
                return $player2->get_deck();
            }
        }
        if($this->user->get_uid() == $player1->get_player_uid()){
            return $player1->get_deck();
        }
        return null;
    }

    public function get_player(){
        $player2 = $this->game->get_player2();
        $player1 = $this->game->get_player1();
        if($player2 != null){
            if($player2->get_player_uid() == $this->user->get_uid()){
                return $player2;
            }
        }
        if($this->user->get_uid() == $player1->get_player_uid()){
            return $player1;
        }
        return null;
    }

    public function check_if_player(){
        $player1 = $this->game->get_player1();
        $player2 = $this->game->get_player2();
        $uid = $this->user->get_uid();
 
        if($this->game->get_player2() != null){
            if($player1->get_player_uid() != $uid || $player2->get_player_uid() != $uid){
                return False;
            }else{
                return True;
            }
        }
        else{
            if($player1->get_player_uid() != $uid){
                return False;
            }
            else{
                return True;
            }
        }
    }

    public function __construct($gameId, $user){
        $this->game = new Pazaak();
        $this->game->build_from_id($gameId);
        $this->user = $user;
    }
}