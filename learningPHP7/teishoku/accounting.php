<?php

require_once 'file_importer.php';

var_dump($_POST);

$errors1 = validate_form($_POST);
$errors2 = validate_form_karaage($_POST);

$errors = array_merge($errors1, $errors2);

if (!empty($errors)) {
    
    print '入力エラーがあります。';
    print '<ul>';
    
    foreach ($errors as $error) {
        
        print '<li>' . $error . '</li>';
    }
    
    print '</ul><br>';
    
    print '<button type="button" onclick="history.back()">戻る</button>';
    
} else {
    
    $post_data = array();
    
    foreach ($_POST as $key => $value) {
        
        if (! strpos($key, '_checked') and strlen(trim($value))) {
            
            $post_data[$key] = $value;
        }
    }
    
    var_dump($post_data);
    Teishoku::show_accounting($post_data);
}

?>