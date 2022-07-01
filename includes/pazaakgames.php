<?php

function get_games($user){
    $handler = DBHandler();
    $sql = "select * from pazaak where playerOne = ? or playerTwo = ?";
}