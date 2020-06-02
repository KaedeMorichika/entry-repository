<?php

require_once 'form_helper.php';

/*
 * 定食屋の部品群
 * プロパティに入るクラスによってメソッドの返り値が変化する。
 */

class TeishokuComponent {
    
    private $dish_class;
    
    public function __construct($dish_class) {
        
        $this->dish_class = $dish_class;
        
    }
    
    public function show_menu (){
        
        $this->dish_class->show_name_price();
        $this->dish_class->show_option();
        
    }
    
    public function show_form (){
        
        $this->dish_class->show_form();
        $this->dish_class->show_option_form();
        
    }
    
    public function get_dish_category () {
        
        return $this->dish_class::
        
    }
    
    public function accounting ($num) {
        
        $total_price = $this->dish_class->getPrice * $num;
        
        return $total_price;
        
    }
    
    
    
}