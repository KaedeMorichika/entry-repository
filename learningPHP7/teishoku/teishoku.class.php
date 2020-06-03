<?php

require_once 'teishoku_component.class.php';

/*
 * 定食屋の内部処理クラス
 */

class Teishoku {
    
    // メニュー組み立てメソッド
    public static function show_menu($teishoku_components) {
        
        print '<table border="1"><tr><th>メニュー</th><th>値段</th></tr>';
        
        foreach ($teishoku_components as $teishoku_component) {
            
            $teishoku_component->show_menu();
            
        }
        
        print '</table>';
        
    }
    
    // フォーム組み立てメソッド
    public static function show_form($teishoku_comopnents, $action) {
        
        print '<form method="POST" action="accounting.php">';
        
        print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
        
        foreach ($teishoku_comopnents as $teishoku_comopnent) {
            
            $teishoku_comopnent->show_form();
            
            
        }
        
        print '</table>';
        
        input_submit('', 'submit');
        
    }
    
    public static function show_accounting($post_data) {
        
        print '<table border="1"><tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
        
        $total_price = 0;
        
        foreach ($post_data as $key => $value) {
            
            $price = Dish::get_price_from_name($key);
            
            if ($key === 'Karaage') {
                $teishoku_component = new TeishokuComponent(new Karaage($key, $price));
                var_dump($teishoku_component);
                $teishoku_component->show_accounting($value);
                $total_price += $teishoku_component->getDish_class()->get_total_price($value);
            }
            
            if ($key === 'ChickenNanban') {
                $teishoku_component = new TeishokuComponent(new ChickenNanban($key, $price));
                $teishoku_component->show_accounting($value);
                $total_price += $teishoku_component->getDish_class()->get_total_price($value);
            }
            
            if ($key === 'Curry') {
                $teishoku_component = new TeishokuComponent(new Curry($key, $price));
                $teishoku_component->show_accounting($value);
                $total_price += $teishoku_component->getDish_class()->get_total_price($value);
            }
            
        }
        print '<tr><td>合計</td><td></td><td>\\' . $total_price . '</td></tr>';
        print '</table>';
        
    }
    
    public function validate_form ($post_data) {
        
        $error = array();
        
        
        
    }
    
}

