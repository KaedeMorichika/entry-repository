<?php

require_once 'teishoku.class.php';

$teishoku = new Teishoku();

$teishoku->show_menu();

if (! empty($_POST['_submit_check'])) {
    
    $form_error = $teishoku->validateTeishokuForm($_POST);
    
    if (!empty($form_error)) {
        $_POST = [];
        $teishoku->show_form($_SERVER['PHP_SELF'], $form_error);
    } else {
        $teishoku->show_accounting($_POST);
    }
} else {
    $teishoku->show_form($_SERVER['PHP_SELF']);
}
?>