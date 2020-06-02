<?php
require_once 'dish.class.php';
require_once 'sauce.class.php';

/*
 * 唐揚げクラス
 */
class Karaage extends Dish {
    
    const CATEGORY = 1;
    // ソースプロパティの追加
    private $sauces;
    
    public function __construct($name, $price) {
        
        parent::__construct($name, $price);

        $this->sauces = array();
        
        $dbname = 'teishoku';
        $user = 'root';        
        
        $sauces = Sauce::get_datas();
        
        foreach ($sauces as $sauce) {
            
            $this->sauces[] = new Sauce($sauce);
            
        }
        
    }
    
    // ソースのメニュー表示メソッド
    public function show_option() {
        
        foreach ($this->sauces as $sauce) {
            
            $sauce->show_name_price();
            
        }
        
    }
    
    // ソースのフォーム表示メソッド
    public function show_option_form() {
        
        foreach ($this->sauces as $sauce) {
            
            $sauce->show_form();
            
        }
        
    }
    
    // 唐揚げカテゴリーを全て取ってくる
    public static function get_datas() {
        
        $stmt = parent::get_datas();
        
        $stmt->execute(array('category' => Karaage::CATEGORY));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}