<?php



class CardType extends DBHandler{
    protected $sqlFilePath = "sql/cardtype.json";
    protected $tableName = "CardType";
    private $pk;
    private $name;
    private $actions;
    private $admin;
    private $special;
    private $image;

    public function get_pk(){
        return $this->pk;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_actions(){
        return $this->actions;
    }

    public function get_actions_str(){
        if($this->actions == null){
            return "Action is null";
        }
        if(count($this->actions) > 1){
            $message = "&#177;" . (string)$this->actions[0]->get_action();
        }
        else{
            if($this->actions[0]->get_action() > 0){
                $message = "+". (string)$this->actions[0]->get_action();
            }
            else{
                $message = (string)$this->actions[0]->get_action();
            }
        }
        return $message;
    }

    public function is_admin_card(){
        return $this->admin;
    }

    public function is_special_card(){
        return $this->special;
    }

    public function get_image_path(){
        return $this->image;
    }

    private function populate(){
        $query = "SELECT * from CardType WHERE pk = ?;";
        $values = array($this->pk);
        $types = array("i");
        $results = $this->execute_query($query, $values, $types);
        if($results->num_rows > 0){
            $data = $results->fetch_all(MYSQLI_ASSOC);
            foreach($data as $row){
                $this->name = $row['name'];
                foreach(json_decode($row['actions']) as $action){
                    $this->actions[] = new CardActions($action);
                }
                $this->admin = $row['admin'];
                $this->special = $row['special'];
                $this->image = $row['image'];
            }
        }
    }

    public function __construct($typeId){
        $this->database_setup();
        $this->pk = $typeId;
        $this->populate();
    }
}