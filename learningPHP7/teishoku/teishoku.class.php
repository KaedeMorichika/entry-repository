<?php 
require 'form_helper.php';

class Dish {
    public $name;
    public  $price;
    
    public function return_name () {
        return $this->name;
    }
    
    public function return_price () {
        return $this->price;
    }
}

class Teishokuya {
    public $menu, $sauce;
    
    public function __construct ($menu, $sauce) {
        $this->menu = $menu;
        $this->sauce = $sauce;
    }
    
    public function show_menu () {
        print '<table border="1"><tr><th>メニュー</th><th>値段</th></tr>';
        foreach ($this->menu as $item) {
            print '<tr><td>'.$item->name.'</td><td>'.$item->price.'</td></tr>';
        }
        print '</table>';
    }
    
    public function show_sauce () {
        print '唐揚げにはソースをつけられます。（各100円）<ul>';
        foreach ($this->sauce as $item) {
            print '<li>'.$item.'ソース</li>';
        }
        print '</ul>';
    }
    
    public function show_form ($path, $errors = '') {
        print '<form method="POST" action="'.$path.'">';
        
        if ($errors) {
            print '入力エラー';
            print '<ul><li>';
            print implode('</li><li>', $errors);
            print '</li></ul>';
        }
        
        print 'ご注文のメニューにチェックを入れ、個数を入力してください。';
        print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
        foreach ($this->menu as $item) {
            print '<tr><td>';
            input_radiocheck('radio', $item->name, $_POST, '1');
            print '</td><td>';
            print $item->name;
            print '</td><td>';
            input_text($item->name.'個数', $_POST);
            print '</td></tr>';
        }
        foreach ($this->sauce as $item) {
            print '<tr><td>';
            input_radiocheck('radio', $item, $_POST, '1');
            print '</td><td>';
            print $item.'ソース';
            print '</td><td>';
            input_text($item.'個数', $_POST);
            print '</td></tr>';
        }
        print '</table>';
        
        input_submit('submit', '会計');
        
        print '<input type="hidden" name="_submit_check" value="1">';
        print '</form>';
    }
    
    public function validate_form () {
        $errors = array();
        foreach ($this->menu as $item) {
            if (!empty($_POST[$item->name])) {
                if (!$errors and empty($_POST[$item->name.'個数'] )) {
                    $errors[] = '正しい個数を入力してください。';
                }
                elseif (!$errors and $_POST[ $item->name.'個数' ] != strval(intval($_POST[ $item->name.'個数' ]))) {
                    $errors[] = '正しい個数を入力してください。';
                }
            } else {
                if (!empty($_POST[ $item->name.'個数' ])) {
                    $errors[] = '正しい個数を入力してください。';
                }
            }
        }
        foreach ($this->sauce as $item) {
            if (!empty($_POST[$item])) {
                if (!$errors and empty($_POST[ $item.'個数' ])) {
                    $errors[] = '正しい個数を入力してください。';
                }
                elseif (!$errors and $_POST[ $item.'個数' ] != strval(intval($_POST[ $item.'個数' ]))) {
                    $errors[] = '正しい個数を入力してください。';
                }
            } else {
                if (!empty($_POST[ $item.'個数' ])) {
                    $errors[] = '正しい個数を入力してください。';
                }
            }  
        }
        return $errors;
    }
    
    public function process_form () {
        $total_price = 0;
        $_SESSION['is_checked'] = true;
        
        print '&nbsp;お会計：';
        print '<table border="1"><tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
        foreach ($this->menu as $item) {
            if (!empty($_POST[$item->name])) {
                print '<tr><td>' . $item->name . '</td><td>' . $_POST[ $item->name.'個数' ] . '</td><td>\\' . $_POST[ $item->name.'個数' ] * $item->price;
                $total_price += $_POST[ $item->name.'個数' ] * $item->price;
                print '</td></tr>';
            }
        }
        foreach ($this->sauce as $item) {
            if (!empty($_POST[$item])) {
                print '<tr><td>' . $item . 'ソース</td><td>' . $_POST[ $item.'個数' ] . '</td><td>\\' . $_POST[ $item.'個数' ] * 100;
                $total_price += $_POST[ $item.'個数' ] * 100;
                print '</td></tr>';
            }
        }
        print '<tr><td>合計</td><td></td><td>\\'.$total_price.'</td></tr>';
        print '</table>';
        print 'ありがとうございました。';
    }
    
    public function add_dish($dish) {
        $this->menu[] = $dish;
    }
    
}
?>