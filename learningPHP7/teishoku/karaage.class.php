<?php
require_once 'CommonFunction.php';
require_once 'dish.class.php';

class Karaage extends Dish {
    
    public function getAllKaraages ($dbname, $user, $pwd = null) {
        
            $dbh = accessDatabase($dbname, $user, $pwd);
            
            $sql = "SELECT * from menu WHERE category = (SELECT id FROM category WHERE name = 'Karaage')";
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Karaage', array(null, null));
        
    }
    
}