<?php

define("ACTIONS", [1,2,3,4,5,6,7,8,9]);

function add_action($db, $name, $admin, $action, $special=False){
    $query = "INSERT INTO CardType (name, admin, actions, special) VALUES (?, ?, ?, ?);";
    $values = array($name, $admin, $action, $special);
    $types = array("sisi");
    return $db->execute_query($query, $values, $types);
}

function get_random_type(){
    $query = "SELECT pk from CardType where special = 0;";
    $db = new DBHandler();
    $results = $db->execute_query($query, array(), array());
    if($results->num_rows > 0){
        $data = $results->fetch_all(MYSQLI_ASSOC);
        return $data[rand(0, count($data) - 1)]['pk'];
    }
    return null;
}

function populate_card_types(){
    $types = new CardType(1);
    $db = new DBHandler();
    $data = null;
    $query = "SELECT * from CardType;";
    $results = $db->execute_query($query, array(), array());
    if($results->num_rows > 0){
        $data = $results->fetch_all(MYSQLI_ASSOC);
    }
    if($data != null){
        foreach($data as $row){
            $action = json_decode($row['actions']);
        }
    }else{
        foreach(ACTIONS as $action){
            $plusName = "Pazak Card +". $action;
            $minusName = "Pazak Card -". $action;
            $specialName = "Pazak Card +/-". $action;
            $plusAction = json_encode([$action]);
            $minusAction = json_encode([$action*-1]);
            $specialAction = json_encode([$action, $action*-1]);
            if($action > 6){
                add_action($db, $plusName, True, $plusAction);
            }else{
                add_action($db, $plusName, False, $plusAction);
                add_action($db, $minusName, False, $minusAction);
                add_action($db, $specialName, False, $specialAction, True);
            }
        }
    }
}