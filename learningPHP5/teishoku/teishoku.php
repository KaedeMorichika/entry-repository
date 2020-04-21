<?php
// フォームヘルパー関数のインポート
require 'form_helper.php';

// セッションの開始
session_start();

// DBの処理
$dsn = 'mysql:dbname=teishoku;host=localhost';
$user = 'root';
$psw = 'db090902';
try {
    $db = new PDO($dsn, $user, $psw);
    $sql1 = 'SELECT name, price FROM menu';
    $sql2 = 'SELECT name FROM sauce';
    $menu = $db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
    $sauce = $db->query($sql2)->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    print 'DB Connection failed:'.$e->getMessage();
    die;
}

// ページ遷移設定
if (!empty($_SESSION['is_checked'])) {
    print '会計済みです。';
} else {
    show_menu();
    if (!empty($_POST['_submit_check'])) {
        if ($form_errors = validate_form()) {
            show_form($form_errors);
        } else {
            process_form();
        }
    } else {
        show_form();
    }
}

// メニュー表示関数
function show_menu() {
    global $menu, $sauce;
   
    print '<table border="1">';
    print '<tr><th>メニュー</th><th>値段</th></tr>';
    foreach ($menu as $item) {
        print '<tr>';
        print '<td>'.$item['name'].'</td><td>'.$item['price'].'</td>';
        print '</tr>';
    }
    print '</table>';
    print '唐揚げにはソースをつけられます。（各100円）<ul>';
    foreach ($sauce as $item) {
        print '<li>'.$item.'ソース</li>';
    }
    print '</ul>';
}

// 入力フォーム表示関数
function show_form($errors = '') {
    global $menu, $sauce;
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    
    if ($errors) {
        print '入力エラー';
        print '<ul><li>';
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }
    
    print 'ご注文のメニューにチェックを入れ、個数を入力してください。';
    print '<table><tr><th></th><th>メニュー</th><th>個数</th></tr>';
    foreach ($menu as $item) {
        print '<tr><td>';
        input_radiocheck('radio', $item['name'], $_POST, '1');
        print '</td><td>';
        print $item['name'];
        print '</td><td>';
        input_text($item['name'].'個数', $_POST);
        print '</td></tr>';
    }
    foreach ($sauce as $item) {
        print '<tr><td>';
        input_radiocheck('radio', $item, $_POST, '1');
        print '</td><td>';
        print $item.'ソース';
        print '</td><td>';
        input_text($item.'個数', $_POST);
        print '</td></tr>';
    }
    print '</table>';
    
    input_submit('submit', '会計');
    
    print '<input type="hidden" name="_submit_check" value="1">';
    print '</form>';
}

// 提出された値をチェックする関数
function validate_form() {
    global $menu, $sauce;
    
    $errors = array();
    foreach ($menu as $item) {
        if (!empty($_POST[$item['name']])) {
            if (!$errors and empty($_POST[$item['name'].'個数'])) {
                $errors[] = '正しい個数を入力してください。';
            }
            elseif (!$errors and $_POST[$item['name'].'個数'] != strval(intval($_POST[$item['name'].'個数']))) {
                $errors[] = '正しい個数を入力してください。';
            }
        } else {
            if (!empty($_POST[$item['name'].'個数'])) {
                $errors[] = '正しい個数を入力してください。';
            }
        }
    }
    foreach ($sauce as $item) {
        if (!empty($_POST[$item])) {
            if (!$errors and empty($_POST[$item.'個数'])) {
                $errors[] = '正しい個数を入力してください。';
            }
            elseif (!$errors and $_POST[$item.'個数'] != strval(intval($_POST[$item.'個数']))) {
                $errors[] = '正しい個数を入力してください。';
            }
        } else {
            if (!empty($_POST[$item.'個数'])) {
                $errors[] = '正しい個数を入力してください。';
            }
        }
        
    }
    
    return $errors;
}

// 提出された値が適切な時の処理関数
function process_form() {
    global $menu, $sauce;
    $total_price = 0;
    $_SESSION['is_checked'] = true;
    
    print '&nbsp;お会計：';
    print '<table border="1"><tr><th>メニュー</th><th>個数</th><th>値段</th></tr>';
    foreach ($menu as $item) {
        if (!empty($_POST[$item['name']])) {
            print '<tr><td>' . $item['name'] . '</td><td>' . $_POST[$item['name'].'個数'] . '</td><td>\\' . $_POST[$item['name'].'個数'] * $item['price'];
            $total_price += $_POST[$item['name'].'個数'] * $item['price'];
            print '</td></tr>';
        }
    }
    foreach ($sauce as $item) {
        if (!empty($_POST[$item])) {
            print '<tr><td>' . $item . 'ソース</td><td>' . $_POST[$item.'個数'] . '</td><td>\\' . $_POST[$item.'個数'] * 100;
            $total_price += $_POST[$item.'個数'] * 100;
            print '</td></tr>';
        }
    }
    print '<tr><td>合計</td><td></td><td>\\'.$total_price.'</td></tr>';
    print '</table>';
    print 'ありがとうございました。';
}
?>