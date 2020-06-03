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
    
    // ソースの会計表示メソッド
    public function show_option_accounting($post_data) {
        
        foreach ($this->sauces as $sauce) {
            
            $total_price = 0;
            
            if (!empty($post_data[$sauce->getName()])) {
                
                $sauce->show_accounting();
                
            }
            
        }
        
    }
    
    public function get_total_price($num) {
        
        $total_price = parent::get_total_price($num);
        
        return $total_price;
        
    }
    
    // 唐揚げカテゴリーを全て取ってくる
    public static function get_datas() {
        
        $stmt = parent::get_datas();
        
        $stmt->execute(array('category' => Karaage::CATEGORY));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}