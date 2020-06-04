<?php

require_once 'file_importer.php';

/*
 * データベース接続
 */
function accessDatabase ($dbname, $user, $pwd = null) {
    
    try {
        
        $dsn = 'mysql:dbname='.$dbname.';host=localhost';
        if (empty($pwd)) {
            $dbh = new PDO($dsn, $user);
        } else {
            $dbh = new PDO($dsn, $user, $pwd);
        }
        
        return $dbh;
        
    } catch (PDOException $e) {
        print 'DB Connection failed:'.$e->getMessage();
        die;
    }
    
}

/*
 * 定食屋フォームバリデーション
 */
function validate_form ($post_data) {
    
    $errors = array();
    $checked_list = array();
    $dish_num_list = array();
    
    foreach ($post_data as $key => $value) {
        
        if (!strpos($key, '_checked')) {
            
            $dish_num_list[$key] = $value;
            
        } else {
            
            $checked_list[$key] = $value;
            
        }
        
    }
    
    if (count($checked_list) === 0) {
        
        $errors[] = '注文がありません。';
        
    } else {
        
        foreach ($dish_num_list as $key => $value) {
            
            if (array_key_exists($key.'_checked', $post_data)) {
                
                if (strlen(trim($value)) == 0) {
                    
                    $errors[] = '選択したメニューの個数を入力してください。';
                    
                } else if ($value !== strval(intval($value))) {
                    
                    $errors[] = '個数は半角数字で入力してください。';
                    
                }
                
            } else {
                
                if (strlen(trim($value))) {
                    
                    $errors[] = '選択していないメニューの個数が入力されています。';
                    
                }
                
            }
            
        }
        
    }
    
    return array_unique($errors);
    
}

/*
 * 唐揚げについてのバリデーション
 */
function validate_form_karaage($post_data) {
    
    $errors = array();
    $sauce_list = Sauce::get_datas();
    
    if (!array_key_exists('Karaage_checked', $post_data)) {
        
        foreach ($sauce_list as $sauce) {
            
            if (array_key_exists($sauce . '_checked', $post_data)) {
                
                $errors[] = 'ソースは唐揚げにのみ付けることができます。';
                break;
                
            }
            
        }
        
    }
    
    return $errors;
    
}


?>