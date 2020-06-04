<?php

require_once 'file_importer.php';

// バリデーション
$errors1 = validate_form($_POST);
$errors2 = validate_form_karaage($_POST);

$errors = array_merge($errors1, $errors2);

if (!empty($errors)) {
    
    // 入力エラーがあった場合にエラー表示
    print '入力エラーがあります。';
    print '<ul>';
    
    foreach ($errors as $error) {
        
        print '<li>' . $error . '</li>';
    }
    
    print '</ul><br>';
    
    print '<button type="button" onclick="history.back()">戻る</button>';
    
} else {
    
    // POST 値の整形
    $post_data = array();
    $teishokuya_parts = array();
    
    foreach ($_POST as $key => $value) {
        
        if (! strpos($key, '_checked') and strlen(trim($value))) {
            
            $post_data[$key] = $value;
            $price = Dish::get_price_from_name($key);
            
            if ($key === 'Karaage') {
                
                $teishokuya_parts[$key] = new Karaage($key, $price);
                
            } else if ($key === 'ChickenNanban') {
                
                $teishokuya_parts[$key] = new ChickenNanban($key, $price);
                
            } else if ($key === 'Curry') {
                
                $teishokuya_parts[$key] = new Curry($key, $price);
                
            }
            
        }
    }
    
    $teishokuya = new Teishokuya($teishokuya_parts);
    
    // 会計表示
    $teishokuya->show_accounting($post_data);
    
}

?>