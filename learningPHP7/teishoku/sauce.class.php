<?php

require_once 'dish.class.php';

class Sauce  extends Dish {

    public function __construct($name) {

        parent::__construct($name, 100);
        
    }
    
    // ソースメニュー表示メソッド
    public function show_name_price() {
        
        print '<tr><td>&nbsp;&nbsp;' . $this->name . 'ソース</td><td>' . $this->price . '円</td></tr>';
        
    }
    
    // ソースフォーム表示メソッド
    public function show_form() {
        
        print '<tr><td>';
        input_radiocheck('radio', $this->name, $_POST, 1);
        print '</td><td>' . $this->name . 'ソース</td><td>';
        input_text($this->name . '_num', $_POST);
        print '</td></tr>';
        
    }
    
    // ソースのデータを全て取ってくる
    public static function get_datas() {
        
        $dbname = 'teishoku';
        $user = 'root';
        
        $dbh = accessDatabase($dbname, $user);
        
        $sql = 'SELECT name FROM sauce';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
        
    }
    
}