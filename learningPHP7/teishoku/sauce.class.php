<?php
class Sauce {
    
    private $id;
    private $name;
    private $price = 100;
    
    public function __construct($id, $name) {
        
        $this->id = $id;
        $this->name = $name;
        
    }
    
    public function getSauceID() {
        return $this->id;
    }
    
    public function getSauceName() {
        return $this->name;
    }
    
    public function getSaucePrice() {
        return $this->price;
    }
    
    public function getAllSauces($dbname, $user, $pwd = null) {
        
        $dbh = accessDatabase($dbname, $user, $pwd);
        
        $sql = 'SELECT id, name FROM sauce';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Sauce', array(null, null));
        
    }
    
}