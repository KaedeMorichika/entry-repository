<?php
require_once 'form_helper.php';

/*
 * 料理のスーパークラス
 */

class Dish {
    
    protected $name;
    protected $price;
    protected $option_list;
    
    public function __construct($name, $price) {
        
        $this->name = $name;
        $this->price = $price;
        
    }
    
    // オプションも含めメニュー表示
    public function show_name_price_with_option() {
        
        $this->show_name_price();
        $this->show_option();
        
    }
    
    // オプションも含めフォーム表示
    public function show_form_with_option() {
        
        $this->show_form();
        $this->show_option_form();
        
    }
    
    // オプションも含め会計表示
    public function show_accounting_with_option($post_data, $key) {
        
        $this->show_accounting($post_data, $key);
        $this->show_option_accounting($post_data, $key);
        
    }
    
    // メニュー表示用メソッド
    public function show_name_price() {
        
        print '<tr><td>' . $this->name . '</td><td>' . $this->price . '円</td></tr>';
        
    }
    
    // フォーム表示用メソッド
    public function show_form() {
        
        print '<tr><td>';
        input_radiocheck('radio', $this->name . '_checked', $_POST, 1);
        print '</td><td>' . $this->name . '</td><td>';
        input_text($this->name, $_POST);
        print '</td></tr>';
        
    }
    
    // 会計表示用メソッド
    public function show_accounting($post_data, $key) {
        
        $total_price = $this->get_total_price($post_data, $key);
        print '<tr><td>' . $this->name . '</td><td>' . $post_data[$key] . '</td><td>\\' . $total_price . '</td><tr>';
        
    }
    
    // オプションのメニュー表示用メソッド
    public function show_option() {
        
    }
    
    // オプションのフォーム表示用メソッド
    public function show_option_form() {
        
    }
    
    // オプションの会計表示メソッド
    public function show_option_accounting($post_data, $key) {
        
    }
    
    // POST された料理の合計金額を返すメソッド
    public function get_total_price($post_data, $key) {
        
        $total_price = $this->price * $post_data[$key];
        
        return $total_price;
        
    }
    
    // そのクラスに属する全てのデータを取ってくる。
    public static function get_datas () {
        
        $dbname = 'teishoku';
        $user = 'root';
        
        $dbh = accessDatabase($dbname, $user);
        
        $sql = 'SELECT name, price FROM menu WHERE category = :category';
        $stmt = $dbh->prepare($sql);
        
        return $stmt;
        
    }
    
    // 名前から値段を取得するメソッド
    public static function get_price_from_name ($name) {
        
        $dbname = 'teishoku';
        $user = 'root';
        
        $dbh = accessDatabase($dbname, $user);
        
        $sql = 'SELECT price FROM menu WHERE name = :name';
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array('name' => $name));
        
        return $stmt->fetch(PDO::FETCH_COLUMN);
        
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
    

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    
    
    
}