<?php
$Lookup = array();
$Lookup["Pazaak Card +/-1"] = "0bae0325121a47c0e516e0e2162b8447032b33f6206a7bbae9fff478abb8aa44fecfe3ba5930ce126d57adb08ddd0b91f44e19209906b7e44b2d517d0d90cdb5";
$Lookup["Pazaak Card +/-2"] = "4787f62383020a31b5d6bfae6a36e8bb3c3aab6f0686e1749e05351b7090506d4b6edde1c42c6ba75fc64ff6b78206ff9363c5dab070acf82da85216e903f5dc";
$Lookup["Pazaak Card +/-3"] = "a683fc7ff14a0588f257fce6f871efb4653e33ebfa57c1880293d70815c0dc106e7c1c6a1bc62503c09a8816a42cfa72596462e10acbffbea90a9e13c4fedfef";
$Lookup["Pazaak Card +/-4"] = "b80ee66416e5df737780b9aecf507b6894df8387356fa533d5d50a7dbdeed3cdaf04ff0de7c81b1566c53f7bf58a9e8728d162ae97e2a3f4840ff6f1babe5bcd";
$Lookup["Pazaak Card +/-5"] = "0c7f28e14fb34f5732fe58c9d4a4a15130a909b705449c7704cd120002e00ae31561e11a5a8d7e837c1673b3b75aaf0319222f0ad1e9e301f68164105f3208fc";
$Lookup["Pazaak Card +/-6"] = "a0a4efd3d9393313ddb89d2567aeaf957ba133f023bf2551a02bf3398ddbc7188ae2048bc49a4481bba90630ce90b52610531756de89c4ce311317ce089e0e3c";
$Lookup["Pazaak Card -1"] = "3c32d9e6d6d5c763bcf61d54bd5b73dbdf423c0cc0a848ba53d7aad454d0e3518153b163899681d79b8b3258d39e99388a7ccc9c3b19541b4ffa29814108dc6a";
$Lookup["Pazaak Card -2"] = "706806c8f9e226ee9df64aadf4b8073ac1b3adb2076ac2e476c1c2dcec84a2e5c3aa68e49ce536f78fd3683fa0dbc646c9f38ce53c2d8ab2c658481b6133df1f";
$Lookup["Pazaak Card -3"] = "aa0e52dc6902e094ef7367f57cc8e0ac4cc29055463d5f1257d47714e97fcedc261d7998827ff1f4411ca9c582990f901954cbda89800fe9a462af072440974b";
$Lookup["Pazaak Card -4"] = "1b1e8ff0735a4958c42fe865dfc13ba676434833047f8f6bbfb9488c7b4080761288300324d9961c0af6cb582dedfd5763a2b07b3c4ce585662c2a64dccff2dc";
$Lookup["Pazaak Card -5"] = "bae6fe90865816214b2f9ba3ff4813b6a31af0de7153029c0f5933d1e42f460cb66d6267cd948be3c249b6851cd5b0750b8ddf645390d1759c28a412cc694694";
$Lookup["Pazaak Card -6"] = "596eb2eda7d04c28caa6d93b24b72ba95715c1d19240b0cb24e745bfbfe72ecf78af28824613a1464dfc7d15b370c15d6e159e6a3d0d31b0573ee6ce75ec2b03";
$Lookup["Pazaak Card +1"] = "4b9d4e83dc05fc9ad3cc95fecc584c8a7a5fe12d9be1fe19565a6432abca213044b3e362a628fe73f0fb112c6ceb5b6d376c1aa6b8b0e05fefdaf7c44130a7e8";
$Lookup["Pazaak Card +2"] = "0525008e3f7c6d80cde502f55668bcf63c12aea8661d19c8ffdc3e867c52daac2151a9fb0d221e2ffabe28f9ad7939b773b52f74c7617271a92df16294819324";
$Lookup["Pazaak Card +3"] = "e3d1ee2f1ec42de39cc8e71d1c43c209a8384bbc67522aaa8afc1c6ee0b598703b3a1ee27a1cb8f9e873fa1f8cd97f41ba35ccf5071a309f83b3a381afdafb03";
$Lookup["Pazaak Card +4"] = "250ab3dbc750e172447f1dfef623529090c3f9cb45943bb6534804a05879b60f349b683944d351da4c4c3d9dc693cbbb548164db244335e8bbae6b7c1d27724a";
$Lookup["Pazaak Card +5"] = "4581d29135f0f9d2f9b1b4d5a07dbca89bc979ac530575d6c627a1cab268fc76776431649c967b1f99d5d30cdbb9b1f9478242a197ab90abf8328fe3e854535b";
$Lookup["Pazaak Card +6"] = "0ca168c84e95b8ce3ba7f570af926d9430e6c73d858c0987a80fd16d50c19bed99370727718b18b9b5d72e7888c852b71f93ac4c237e27bbb76869f4a3dd45fd";
define("HASHLOOKUP",  $Lookup);

class CardType extends DBHandler{
    protected $sqlFilePath = "sql/cardtype.json";
    protected $tableName = "CardType";
    private $pk;
    private $name;
    private $actions;
    private $admin;
    private $special;
    private $image;
    private $hashName;
    private $hash;

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

    private function hashCheck(){
        $validHash = HASHLOOKUP[$this->hashName];
        if($validHash == $this->hash){
            $query = "SELECT pk FROM CardType WHERE name = ?";
            $values = array($this->hashName);
            $types = array("s");
            $result = $this->execute_query($query, $values, $types);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $this->pk = $row["pk"];
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    private function populate(){
        $query = "SELECT * from CardType WHERE pk = ?;";
        if($this->pk == -1){
            if(!$this->hashCheck()){
                $this->pk = null;
                return False;
            }
        }
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
        return True;
    }

    public function __construct($typeId, $hashName = null, $hash = null){
        $this->database_setup();
        $this->pk = $typeId;
        if($hashName != null){
            $this->hashName = $hashName;
        }
        if($hash != null){
            $this->hash = $hash;
        }
        $this->populate();
    }
}