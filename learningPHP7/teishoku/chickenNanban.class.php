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
    
    public function show_menu() {
        
        print '<tr><td>' . $this->name . '</td><td>' . $this->price . '円</td></tr>';
        
    }
    
    public function show_form() {
        
        print '<tr><td>';
        input_radiocheck('radio', $this->name . '_checked', $_POST, 1);
        print '</td><td>' . $this->name . '</td><td>';
        input_text($this->name, $_POST);
        print '</td></tr>';
        
    }
    
    public function show_accounting($post_data, $key) {
        
        $total_price = $this->get_total_price($post_data, $key);
        print '<tr><td>' . $this->name . '</td><td>' . $post_data[$key] . '</td><td>\\' . $total_price . '</td><tr>';
        
    }
    
    public function get_total_price($post_data, $key) {
        
        $total_price = $this->price * $post_data[$key];
        
        return $total_price;
        
    }
    
    // チキン南蛮のデータを全て取ってくる
    public static function get_datas() {
        
        $stmt = parent::get_datas();
        
        $stmt->execute(array('category' => ChickenNanban::CATEGORY));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
}