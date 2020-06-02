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
        
        input_submit('submit', 'submit');
        
    }
    
    public function validate_form ($post_data) {
        
        $error = array();
        
        
        
    }
    
}

