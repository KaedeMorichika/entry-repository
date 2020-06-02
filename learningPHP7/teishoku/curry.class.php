<?php

require_once 'dish.class.php';

/*
 * カレークラス
 */
class Curry extends Dish {
    
    const CATEGORY = 3;
    
    public function __construct($name, $price) {
        
        parent::__construct($name, $price);
        $this->category = 3;
        
    }
    
    // カレーのデータを全て取ってくる
    public static function get_datas() {
        
        $stmt = parent::get_datas();
        
        $stmt->execute(array('category' => Curry::CATEGORY));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}