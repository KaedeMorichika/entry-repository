<?php

require_once 'dish.class.php';

/*
 * チキン南蛮クラス
 */
class ChickenNanban extends Dish {
    
    const CATEGORY = 2;
    
    public function __construct($name, $price) {
        
        parent::__construct($name, $price);
        $this->category = 2;
        
    }
    
    // チキン南蛮のデータを全て取ってくる
    public static function get_datas() {
        
        $stmt = parent::get_datas();
        
        $stmt->execute(array('category' => ChickenNanban::CATEGORY));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}