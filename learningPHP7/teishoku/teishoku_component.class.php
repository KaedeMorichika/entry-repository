<?php

require_once 'form_helper.php';

/*
 * 定食屋の部品群
 * プロパティに入るクラスによってメソッドの返り値が変化する。
 */

class TeishokuComponent {
    
    private $dish_class;
    
    /**
     * @return mixed
     */
    public function getDish_class()
    {
        return $this->dish_class;
    }

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
    
    public function show_accounting ($num) {
        
        $this->dish_class->show_accounting($num);
        
    }
    
}