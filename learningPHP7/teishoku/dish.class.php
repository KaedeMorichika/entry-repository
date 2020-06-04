<?php
require_once 'form_helper.php';

/*
 * 料理のスーパークラス
 */

abstract class Dish {
    
    protected $name;
    protected $price;
    protected $option_list;
    
    public function __construct($name, $price) {
        
        $this->name = $name;
        $this->price = $price;
        
    }
    
    // メニュー表示用メソッド
    abstract public function show_menu();
    
    // フォーム表示用メソッド
    abstract public function show_form();
    
    // 会計表示用メソッド
    abstract public function show_accounting($post_data, $key);
    
    // POST された料理の合計金額を返すメソッド
    abstract public function get_total_price($post_data, $key);
    
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