<?php

require_once 'teishoku_component.class.php';

/*
 * 定食屋の内部処理クラス
 */

class Teishoku {
    
    // メニュー組み立てメソッド
    public static function show_menu($teishoku_components) {
        
        print '<p1>お品書き<p1><br>';
        print '<table border="1"><tr><th>メニュー</th><th>値段</th></tr>';
        
        foreach ($teishoku_components as $teishoku_component) {
            
            $teishoku_component->show_menu();
            
        }
        
        print '</table>';
        
    }
    
    // フォーム組み立てメソッド
    public static function show_form($teishoku_comopnents, $action) {
        
        print 'ご注文になるメニューにチェックを入れ、個数を入力してください。';
        
        print '<form method="POST" action="accounting.php">';
        
        print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
        
        foreach ($teishoku_comopnents as $teishoku_comopnent) {
            
            $teishoku_comopnent->show_form();
            
            
        }
        
        print '</table>';
        
        print '<br>';
        
        input_submit('', 'submit');
        
    }
    
    // 会計組み立てメソッド
    public static function show_accounting($post_data) {
        
        print '<table border="1"><tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
        
        $total_price = 0;
        
        foreach ($post_data as $key => $value) {
            
            $teishoku_component = null;
            $price = Dish::get_price_from_name($key);
            
            // POST 値に応じて、TeishokuComponent クラスに入る料理クラスが変化。
            if ($key === 'Karaage') {
                
                $teishoku_component = new TeishokuComponent(new Karaage($key, $price));
                
            } else if ($key === 'ChickenNanban') {
                
                $teishoku_component = new TeishokuComponent(new ChickenNanban($key, $price));
                
            } else if ($key === 'Curry') {
                
                $teishoku_component = new TeishokuComponent(new Curry($key, $price));
                
            }
            
            if (!empty($teishoku_component)) {
                $teishoku_component->show_accounting($post_data, $key);
                $total_price += $teishoku_component->getDish_class()->get_total_price($post_data, $key);
            }

        }
        print '<tr><td>合計</td><td></td><td>\\' . $total_price . '</td></tr>';
        print '</table>';
        
    }
        
}

