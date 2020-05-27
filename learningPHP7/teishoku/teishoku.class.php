<?php
require_once 'form_helper.php';
require_once 'CommonFunction.php';
require_once 'category.class.php';
require_once 'sauce.class.php';

class Teishoku {
    private $menu;
    private $display_sauce;
    
    public function __construct() {
        
        $this->display_sauce = false;
        $this->sauces = null;
        
        $dbname = 'teishoku';
        $user = 'root';
        
        $dbh = accessDatabase($dbname, $user);
        
        $sql = 'SELECT * FROM menu';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $dishes = [];
        
        foreach ($menu as $dish) {
            
            if ($dish['with_sauce'] == 1) {
                $this->display_sauce = true;
                $this->sauces = Sauce::getAllSauces($dbname, $user);
            }
            $dishes[] = Category::assignDishClass($dish, $dbname, $user);
            
        }

        $this->menu = $dishes;
        
    }
    
    public function getDishes() {
        
        return $this->dishes;
        
    }
    
    public function getSauces() {
        
        return $this->sauces;
        
    }
    
    
    
    public function show_menu() {
        
        print '<table border="1"><tr><th>メニュー</th><th>値段</th></tr>';
        
        foreach ($this->menu as $dish) {
            
            print '<tr>';
            print '<td>'.$dish->getName().'</td><td>'.$dish->getPrice().'</td>';
            print '</tr>';
            
            if ($dish->getWithSauce() == 1) {
                $sauces = $dish->getSauces();
            }
        }
        
        if ($this->display_sauce) {
            
            print '</table>';
            print '<p>唐揚げは、以下のソースを選べます。（各100円）</p>';
            print '<ul>';
            
            foreach ($sauces as $sauce) {
                print '<li>' . $sauce->getSauceName() . 'ソース</li>';
            }
            
            print '</ul>';
        }
        
    }
    
    public function show_form($action, $errors = null) {
        
        if (!empty($errors)) {
            
            print '入力エラー：';
            print '<ul>';
            
            if (is_array($errors)) {
                foreach ($errors as $error) {
                    print '<li>' . $error . '</li>';
                }
            } else {
                print '<li>' . $errors . '</li>';
            }
            
            print '</ul>';
        }
        
        print '&nbsp;&nbsp;ご注文になるメニューにチェックを入れて、個数を入力してください。';
        
        print '<form method="POST" action='.$action.'>';
        print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
        
        foreach ($this->menu as $dish) {
            
            $dish_id = $dish->getID();
            $dish_name = $dish->getName();
            
            print '<tr><td>';
            input_radiocheck('radio', $dish_name.'_id', $_POST, $dish_id);
            print '</td><td>';
            print $dish_name;
            print '</td><td>';
            input_text($dish_name.'_num', $_POST);
            print '</td></tr>';
            
            
            if ($dish->getWithSauce() == 1) {
                foreach ($dish->getSauces() as $sauce) {
                    
                    $sauce_id = $sauce->getSauceID();
                    $sauce_name = $sauce->getSauceName();
                    print '<tr><td>';
                    input_radiocheck('radio', $dish_name . '_' . $sauce_name . '_id', $_POST, $sauce_id);
                    print '</td><td>';
                    print $sauce_name . 'ソース';
                    print '</td><td>';
                    input_text($dish_name . '_' . $sauce_name . '_num', $_POST);
                    print '</td></tr>';
                }
            }
            
        }
        
        print '</table>';
        print '<input type="hidden" name="_submit_check" value="1">';
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
            $errors[] = '注文がありません。';
        }
        
        if (empty($errors)) {
            foreach ($this->menu as $dish) {
                
                $dish_id = $dish->getID();
                $dish_name = $dish->getName();
                
                if (empty($post_data[$dish_name . '_id'])) {
                    
                    if (! empty($post_data[$dish_name . '_num'])) {
                        $errors[] = '選択されていないメニューの個数が入力されています。';
                    }
                    
                    if ($dish->getWithSauce() == 1) {
                        
                        foreach ($dish->getSauces() as $sauce) {
                            
                            $sauce_name = $sauce->getSauceName();
                            
                            if (!empty($post_data[$dish_name . '_' . $sauce_name . '_id']) or !empty($post_data[$dish_name . '_' . $sauce_name . '_num'])) {
                                $errors[] = 'ソースは唐揚げにのみ付けられます。';
                            }
                        }
                        
                    }
                } else {
                    
                    if (empty($post_data[$dish_name . '_num'])) {
                        $errors[] = '選択されたメニューの個数が入力されていません。';
                    } elseif ($post_data[$dish_name . '_num'] != strval(intval($post_data[$dish_name . '_num']))) {
                        $errors[] = 'メニューの個数は半角数字で入力してください。';
                    }
                    
                    if ($dish->getWithSauce() == 1) {
                        
                        foreach ($dish->getSauces() as $sauce) {
                            
                            $sauce_name = $sauce->getSauceName();
                            
                            if (empty($post_data[$dish_name . '_' . $sauce_name . '_id'])) {
                                if (! empty($post_data[$dish_name . '_' . $sauce_name . '_num'])) {
                                    $errors[] = '選択されていないソースの個数が入力されています。';
                                }
                            } else {
                                
                                if (empty($post_data[$dish_name . '_' . $sauce_name . '_num'])) {
                                    $errors[] = '選択されたソースの個数が入力されていません。';
                                } elseif ($post_data[$dish_name . '_' . $sauce_name . '_num'] != strval(intval($post_data[$dish_name . '_' . $sauce_name . '_num']))) {
                                    $errors[] = 'ソースの個数は半角数字で入力してください。';
                                }
                                
                            }
                        }
                        
                    }
                }
            }
            
            
            if ($this->display_sauce) {
                foreach ($this->sauces as $sauce) {
                    
                    $sauce_id = $sauce->getSauceID();
                    $sauce_name = $sauce->getSauceName();
                    
                    if (empty($post_data[$sauce_name . '_id'])) {
                        
                        if (! empty($post_data[$sauce_name . '_num'])) {
                            $errors[] = 'チェックされていないメニューの個数が入力されています。';
                        }
                    } else {
                        
                        if (empty($post_data[$sauce_name . '_num'])) {
                            $errors[] = 'チェックされたメニューの個数が入力されていません。';
                        } elseif ($post_data[$sauce_name . '_num'] != strval(intval($post_data[$sauce_name . '_num']))) {
                            $errors[] = 'メニューの個数は半角数字で入力してください。';
                        }
                    }
                }
            }
        }
        return array_unique($errors);
    }
    
    public function show_accounting($post_data) {
        
        $total_price = 0;
        
        print '<table border="1">';
        
        print '<tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
        
        foreach ($this->menu as $dish) {
            
            $dish_name = $dish->getName();
            
            if (!empty($post_data[$dish_name.'_id'])) {
                
                $dish_price = $dish->getPrice();
                $dish_num = $post_data[$dish_name.'_num'];
                $price = $dish_price * $dish_num;
                $total_price += $price;
                
                print '<tr><td>'.$dish_name.'</td><td>'.$dish_num.'</td><td>'.$price.'円</td></tr>';
                
                if ($dish->getWithSauce() == 1) {
                    foreach ($dish->getSauces() as $sauce) {
                        
                        $sauce_name = $sauce->getSauceName();
                        
                        if (! empty($post_data[$dish_name . '_' . $sauce_name . '_id'])) {
                            
                            $sauce_price = $sauce->getSaucePrice();
                            $sauce_num = $post_data[$dish_name . '_' . $sauce_name . '_num'];
                            $price = $sauce_price * $sauce_num;
                            $total_price += $price;
                            
                            print '<tr><td>' . $sauce_name . ' ソース</td><td>' . $sauce_num . '</td><td>' . $price . '円</td></tr>';
                        }
                        
                    }
                }
            }
            
        }
        
        print '<tr><td>合計金額</td><td></td><td>'.$total_price.'円</td></tr>';
        
        print '</table>';
        print '<br>';
        print '<button onclick="history.back()">戻る</button>';
    }
}

