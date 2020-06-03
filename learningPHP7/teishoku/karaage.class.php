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
    
    public function __construct($name, $price, $sauces=null) {
        
        parent::__construct($name, $price);
        
        $this->sauces = $sauces;
        
        $this->option_list = array();
        
        $dbname = 'teishoku';
        $user = 'root';        
        
        $sauce_list = array();
        $sauces = Sauce::get_datas();
        
        foreach ($sauces as $sauce) {
            
            $sauce_list[] = new Sauce($sauce);
            
        }
        
        $this->option_list['sauce_list'] = $sauce_list;
        
    }
    
    // sauces プロパティを set
    public function setSauces($sauces) {
        
        $this->sauces = $sauces;
        
    }
    
    // sauces プロパティに add
    public function addSauce($sauce) {
        
        $this->sauces[] = $sauce;
        
    }
    
    // ソースのメニュー表示メソッド
    public function show_option() {
        
        foreach ($this->option_list['sauce_list'] as $sauce) {
            
            $sauce->show_name_price();
            
        }
        
    }
    
    // ソースのフォーム表示メソッド
    public function show_option_form() {
        
        foreach ($this->option_list['sauce_list'] as $sauce) {
            
            $sauce->show_form();
            
        }
        
    }
    
    // ソースの会計表示メソッド
    public function show_option_accounting($post_data, $key) {
            
            foreach ($this->option_list['sauce_list'] as $sauce) {
                
                $total_price = 0;
                
                if (! empty($post_data[$sauce->getName()])) {
                    $this->addSauce(new Sauce($sauce->getName()));
                    $sauce->show_accounting($post_data , $sauce->getName());
                }
            }
    }
    
    // オプションも加える。
    public function get_total_price($post_data, $key) {
        
        $total_price = parent::get_total_price($post_data, $key);
        
        if (! empty($this->sauces)) {
            foreach ($this->sauces as $sauce) {
                
                $total_price += $sauce->get_total_price($post_data, $sauce->getName());
                
            }
        }
        
        return $total_price;
        
    }
    
    // 唐揚げカテゴリーを全て取ってくる
    public static function get_datas() {
        
        $stmt = parent::get_datas();
        
        $stmt->execute(array('category' => Karaage::CATEGORY));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}