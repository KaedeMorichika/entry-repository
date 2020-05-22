<?php
require_once 'teishoku.class.php';

$teishoku = new Teishoku();

$errors = $teishoku->validateTeishokuForm($_POST);

if (count($errors) > 0) {
    
    print '<form action="teishoku.php" method="POST">';
    
    print '入力エラーです。';
    print '<ul>';
    
    foreach ($errors as $error) {
        print '<li>'.$error.'</li>';
        print '<input type="hidden" name="errors" value[]="'.$error.'"';
    }
    
    print '<ul>';
    
    print '<input type="submit" value="戻る">';
    print '</form>';
    
} else {
    header('Location: accounting.php', true, 307);
}
?>