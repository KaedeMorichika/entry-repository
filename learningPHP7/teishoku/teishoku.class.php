<?php
require_once 'form_helper.php';

class Teishoku {
    private $dishes;
    private $sauces;
    
    public function __construct() {
        
        $dbname = 'teishoku';
        $user = 'root';
        $this->dishes = Dish::getAllDishes($dbname, $user);
        $this->sauces = Sauce::getAllSauces($dbname, $user);
        
    }
    
    public function getDishes() {
        
        return $this->dishes;
        
    }
    
    public function getSauces() {
        
        return $this->sauces;
        
    }
    
    public function show_menu() {
        
        print '<table border="1"><tr><th>メニュー</th><th>値段</th></tr>';
        
        foreach ($this->dishes as $dish) {
            print '<tr>';
            print '<td>'.$dish->getDishName().'</td><td>'.$dish->getDishPrice().'</td>';
            print '</tr>';
        }
        
        print '</table>';
        print '<p>唐揚げは、以下のソースを選べます。（各100円）</p>';
        print '<ul>';
        
        foreach ($this->sauces as $sauce) {
            print '<li>'.$sauce->getSauceName().'ソース</li>';
        }
        
        print '</ul>';
        
    }
    
    public function show_form($action, $errors = null) {
        
        if (!empty($errors)) {
            print '入力エラー：';
            print '<ul>';
            
            foreach ($errors as $error) {
                print '<li>'.$error.'</li>';
            }
            
            print '</ul>';
        }
        
        print '<form method="POST" action='.$action.'>';
        print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
        
        foreach ($this->dishes as $dish) {
            
            $dish_id = $dish->getDishID();
            $dish_name = $dish->getDishName();
            
            print '<tr><td>';
            input_radiocheck('radio', $dish_name.'_id', $_POST, $dish_id);
            print '</td><td>';
            print $dish_name;
            print '</td><td>';
            input_text($dish_name.'_num', $_POST);
            print '</td>';
            
        }
        
        foreach ($this->sauces as $sauce) {
            
            $sauce_id = $sauce->getSauceID();
            $sauce_name = $sauce->getSauceName();
            
            print '<tr><td>';
            input_radiocheck('radio', $sauce_name.'_id', $_POST, $sauce_id);
            print '</td><td>';
            print $sauce_name.'ソース';
            print '</td><td>';
            input_text($sauce_name.'_num', $_POST);
            print '</td>';
        }
        print '</table>';
        input_submit('submit', '会計へ');
        print '</form>';
        
    }

    public function validateTeishokuForm($post_data) {
        
        $errors = [];
        $no_order = true;
        
        foreach ($post_data as $key => $value) {
            if (strpos($key, '_id')) {
                $no_order = false;
                break;
            }
        }
        
        if ($no_order) {
            $errors = '注文がありません。';
        }
        
        if (count($errors) === 0) {
            foreach ($this->dishes as $dish) {
                
                $dish_id = $dish->getDishID();
                $dish_name = $dish->getDishName();
                
                if (empty($post_data[$dish_name . '_id'])) {
                    
                    if (! empty($post_data[$dish_name . '_num'])) {
                        $errors[] = '選択されていないメニューの個数が入力されています。';
                    }
                } else {
                    
                    if (empty($post_data[$dish_name . '_num'])) {
                        $errors[] = '選択されたメニューの個数が入力されていません。';
                    } elseif ($post_data[$dish_name . '_num'] != strval(intval($post_data[$dish_name . '_num']))) {
                        $errors[] = 'メニューの個数は半角数字で入力してください。';
                    }
                }
            }
            
            foreach ($this->sauces as $sauce) {
                
                $sauce_id = $sauce->getSauceID();
                $sauce_name = $sauce->getSauceName();
                
                if (empty($post_data[$sauce_name . '_id'])) {
                    
                    if (! empty($post_data[$sauce_name . '_num'])) {
                        $errors[] = '選択されていないメニューの個数が入力されています。';
                    }
                } else {
                    
                    if (empty($post_data[$sauce_name . '_num'])) {
                        $errors[] = '選択されたメニューの個数が入力されていません。';
                    } elseif ($post_data[$sauce_name . '_num'] != strval(intval($post_data[$sauce_name . '_num']))) {
                        $errors[] = 'メニューの個数は半角数字で入力してください。';
                    }
                }
            }
        }
        return $errors;
    }
    
    public function show_accounting($post_data) {
        
        $total_price = 0;
        
        print '<table border="1">';
        
        print '<tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
        
        foreach ($this->dishes as $dish) {
            
            if (!empty($post_data[$dish_name.'_id'])) {
                
                $dish_name = $dish->getDishName();
                $dish_price = $dish->getDishPrice();
                $dish_num = $post_data[$dish_name.'_num'];
                $price = $dish_price * $dish_num;
                $total_price += $price;
                
                print '<tr><td>'.$dish_name.'</td><td>'.$dish_num.'</td><td>'.$price.'</td></tr>';
            }
            
        }
        
        foreach ($this->sauces as $sauce) {
            
            if (!empty($post_data[$dish_name.'_id'])) {
                
                $sauce_name = $sauce->getSauceName();
                $sauce_price = $sauce->getSaucePrice();
                $sauce_num = $post_data[$sauce_name.'_num'];
                $price = $sauce_price * $sauce_num;
                $total_price += $price;
                
                print '<tr><td>'.$sauce_name.'</td><td>'.$sauce_num.'</td><td>'.$price.'</td></tr>';
            }
            
        }
        
        print '<tr><td>合計金額</td><td></td><td>'.$total_price.'</td></tr>';
        
        print '</table>';
    }
}

class Dish {
    private $id;
    private $name;
    private $price;
    
    public function getDishID() {
        return $this->id;
    }
    
    public function getDishName() {
        return $this->name;
    }
    
    public function getDishPrice() {
        return $this->price;
    }
    
    public function getAllDishes($dbname, $user, $pwd = null) {
        try {
            $dsn = 'mysql:dbname='.$dbname.';host=localhost';
            if (empty($pwd)) {
                $dbh = new PDO($dsn, $user);
            } else {
                $dbh = new PDO($dsn, $user, $pwd);
            }
            
            $sql = 'SELECT * FROM menu';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Dish');
            
        } catch (PDOException $e) {
            print 'DB Connection failed:'.$e->getMessage();
            die;
        }
    }
}

class Sauce {
    private $id;
    private $name;
    private $price = 100;
    
    public function getSauceID() {
        return $this->id;
    }
    
    public function getSauceName() {
        return $this->name;
    }
    
    public function getSaucePrice() {
        return $this->price;
    }
    
    public function getAllSauces($dbname, $user, $pwd = null) {
        try {
            $dsn = 'mysql:dbname='.$dbname.';host=localhost';
            if (empty($pwd)) {
                $dbh = new PDO($dsn, $user);
            } else {
                $dbh = new PDO($dsn, $user, $pwd);
            }
            
            $sql = 'SELECT * FROM sauce';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Sauce');
            
        } catch (PDOException $e) {
            print 'DB Connection failed:'.$e->getMessage();
            die;
        }
    }
}