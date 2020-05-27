<?php
require_once 'karaage.class.php';
require_once 'curry.class.php';
require_once 'sauce.class.php';

class Category {
    
    const KARAAGE = 1;
    const CURRY = 2;
    
    public function assignDishClass ($dish, $dbname = null, $user = null, $pwd = null) {
        
        switch ($dish['category']) {
            
            case Category::KARAAGE:
                if ($dish['with_sauce'] == 1) {
                    $sauces = Sauce::getAllSauces($dbname, $user, $pwd);
                } else {
                    $sauces = null;
                }
                
                $dish_class = new Karaage($dish['id'], $dish['name'], $dish['price'], $dish['with_sauce'], $sauces);
                
                break;
                
            case Category::CURRY:
                $dish_class =  new Curry($dish['id'], $dish['name'], $dish['price']);
                
                break;
            
        }
        
        return $dish_class;
        
    }
    
}