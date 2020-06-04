<?php

require_once 'file_importer.php';

/*
 * 定食屋の内部処理クラス
 */

class Teishokuya {
    
    private $teishokuya_parts;
    
    public function __construct($teishokuya_parts) {
        
        $this->teishokuya_parts = $teishokuya_parts;
        
    }
    
    /**
     * @return mixed
     */
    public function getTeishokuya_parts()
    {
        return $this->teishokuya_parts;
    }

    /**
     * @param mixed $teishokuya_parts
     */
    public function setTeishokuya_parts($teishokuya_parts)
    {
        $this->teishokuya_parts = $teishokuya_parts;
    }
    
    public function addTeishokuya_parts($teishokuya_part) {
        
        $this->teishokuya_parts[] = $teishokuya_part;
        
    }

    // メニュー組み立てメソッド
    public function show_menu() {
        
        print '<p1>お品書き<p1><br>';
        print '<table border="1"><tr><th>メニュー</th><th>値段</th></tr>';
        
        foreach ($this->teishokuya_parts as $teishoku_part) {
            
            $teishoku_part->show_menu();
            
        }
        
        print '</table>';
        
    }
    
    // フォーム組み立てメソッド
    public function show_form($action) {
        
        print 'ご注文になるメニューにチェックを入れ、個数を入力してください。';
        
        print '<form method="POST" action="accounting.php">';
        
        print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
        
        foreach ($this->teishokuya_parts as $teishoku_part) {
            
            $teishoku_part->show_form();
            
        }
        
        print '</table>';
        
        print '<br>';
        
        input_submit('', 'submit');
        
    }
    
    // 会計組み立てメソッド
    public function show_accounting($post_data) {
        
        print '<table border="1"><tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
        
        $total_price = 0;

        foreach ($post_data as $key => $value) {
            
            if (array_key_exists($key, $this->teishokuya_parts)) {
                
                $this->teishokuya_parts[$key]->show_accounting($post_data, $key);
                $total_price += $this->teishokuya_parts[$key]->get_total_price($post_data, $key);
            
            }
            
        }
        print '<tr><td>合計</td><td></td><td>\\' . $total_price . '</td></tr>';
        print '</table>';
        
    }
        
}

