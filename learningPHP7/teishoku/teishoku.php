<?php
// フォームヘルパー関数のインポート
require 'teishoku.class.php';

// セッションの開始
session_start();

// DBの処理
$dsn = 'mysql:dbname=teishoku;host=localhost';
$user = 'root';
try {
    $db = new PDO($dsn, $user);
    $sql1 = 'SELECT name, price FROM menu';
    $sql2 = 'SELECT name FROM sauce';
    $menu = $db->query($sql1, PDO::FETCH_CLASS, 'Dish')->fetchAll();
    $sauce = $db->query($sql2)->fetchAll(PDO::FETCH_COLUMN);
    $teishoku = new Teishokuya($menu, $sauce);
} catch (PDOException $e) {
    print 'DB Connection failed:'.$e->getMessage();
    die;
}

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