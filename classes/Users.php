
<?php

class Users extends DBHandler{
    protected $sqlFilePath = "sql/users.json";
    protected $tableName = "Users";
    private $characterName;
    private $uid;
    private $gamblingLimit;
    private $gamblingDebt;
    private $defaultDeck;
    private $totalWins;
    private $totalGames;
    private $jsonObj;

    public function get_default_deck(){
        return $this->defaultDeck;
    }

    public function get_total_wins(){
        return $this->totalWins;
    }

    public function get_total_games(){
        return $this->totalGames;
    }

    public function get_total_loses(){
        return $this->totalGames - $this->totalWins;
    }

    public function get_name(){
        return $this->characterName;
    }
    
    private function process_character_info(){
        $swcapi = $this->jsonObj->swcapi;
        $this->characterName = $swcapi->character->name;
        $this->uid = explode(":", $swcapi->character->uid)[1];
        if(!$this->query_for_user_by_uid()){
            $this->build_user();
        }
    }

    private function build_user(){
        $query = "INSERT INTO $this->tableName (uid, characterName) VALUES (?, ?);";
        if($this->uid != null and $this->characterName != null){
            $values = array($this->uid, $this->characterName);
            $types = array("is");
            $result = $this->execute_query($query, $values, $types);
        }
    }

    private function set_values($result){
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach($data as $row){
            $this->characterName = $row['characterName'];
            $this->uid = $row['uid'];
            $this->gamblingLimit = $row['gamblingLimit'];
            $this->gamblingDebt = $row['gamblingDebt'];
            $this->defaultDeck = $row['defaultDeck'];
            $this->totalWins = $row['totalwins'];
            $this->totalGames = $row['totalgames'];
        }
    }

    public function query_for_user_by_name(string $characterName = null){
        $query = "SELECT * FROM $this->tableName WHERE characterName like ?";
        if($characterName != null){
            $result = $this->execute_query($query, array($characterName), array("s"));
        }else{
            if($this->characterName != null){
                $result = $this->execute_query($query, array($this->characterName), array("s"));
            }else{
                return False;
            }
        }
        
        if ($result->num_rows == 0){
            return False;
        }
        $this->set_values($result);
        $this->gamblingLimit = 200;
        return True;
    }

    public function get_gambling_debt(){
        return $this->gamblingDebt;
    }

    public function get_gambling_limit(){
        return $this->gamblingLimit;
    }

    public function build_user_from_database($uid){
        $this->query_for_user_by_uid($uid);
    }

    public function query_for_user_by_uid(int $uid = -1){
        $query = "SELECT * FROM $this->tableName WHERE uid = ?";
        if($uid > -1){
            $result = $this->execute_query($query, array($uid), array("i"));
        }else{
            if($this->uid != null){
                $result = $this->execute_query($query, array($this->uid), array("i"));
            }
            else{
                return False;
            }
        }
        if ($result->num_rows == 0){
            return False;
        }
        $this->set_values($result);
        return True;
    }

    public function get_character_name(){
        return $this->characterName;
    }

    public function get_uid(){
        return $this->uid;
    }

    public function __construct($userInfo=null){
        $this->database_setup();
        if($userInfo != null){
            $this->jsonObj = $userInfo;
            $this->process_character_info();
        }
    }
}