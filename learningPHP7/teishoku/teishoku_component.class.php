<?php

require_once 'form_helper.php';

/*
 * 定食屋の部品群
 * プロパティに入る料理クラスによってメソッドの返り値が変化する。
 * EX) Karaage, ChickenNanban, Curry
 * 料理クラス呼び出しの一本化。
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
    
    // 料理クラスの指定
    public function __construct($dish_class) {
        
        $this->dish_class = $dish_class;
        
    }
    
    // メニュー表示メソッド
    public function show_menu (){
        
        $this->dish_class->show_name_price();
        $this->dish_class->show_option();
        
    }
    
    // フォーム表示メソッド
    public function show_form (){
        
        $this->dish_class->show_form();
        $this->dish_class->show_option_form();
        
    }
    
    // 会計表示メソッド
    public function show_accounting ($post_data, $key) {
        
        $this->dish_class->show_accounting($post_data, $key);
        $this->dish_class->show_option_accounting($post_data, $key);
        
    }
    
}