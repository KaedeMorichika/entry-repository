<?php

require_once 'file_importer.php';

var_dump($_POST);

$post_data = array();

foreach ($_POST as $key => $value) {
    
    if (strlen(trim($value)) and !strpos($key, '_checked')) {
        
        $post_data[$key] = $value;
        
    }
    
}

Teishoku::show_accounting($post_data);

?>