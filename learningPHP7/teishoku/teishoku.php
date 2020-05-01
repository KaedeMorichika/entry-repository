<?php
// フォームヘルパー関数のインポート
require_once 'teishoku.class.php';

// セッションの開始
session_start();
$menu = Dish::getMenu();
$sauce = Dish::getSauce();
$teishoku = new Teishokuya($menu, $sauce);

// ページ遷移設定

if (!empty($_SESSION['is_checked'])) {
    print '会計済みです。';
} else {

    $teishoku->show_menu();
    $teishoku->show_sauce();
    if (!empty($_POST['_submit_check'])) {
        if ($form_errors = $teishoku->validate_form()) {
            $teishoku->show_form($_SERVER['PHP_SELF'], $form_errors);
        } else {
            $teishoku->process_form();
        }
    } else {
        $teishoku->show_form($_SERVER['PHP_SELF']);
    }
}
?>