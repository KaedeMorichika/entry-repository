<?php
require_once 'CommonFunction.php';
require_once 'dish.class.php';

class Curry extends Dish {
    
    public function getAllCurries ($dbname, $user, $pwd = null) {
        
        $dbh = accessDatabase($dbname, $user, $pwd);
        
        $sql = "SELECT * from menu WHERE category = (SELECT id FROM category WHERE name = 'Curry')";
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Curry', array(null, null));
        
    }
    
}