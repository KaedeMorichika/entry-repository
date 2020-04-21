<?php
// フォームヘルパー関数のインポート
require 'form_helper.php';

// セッションの開始
session_start();

// DBの設定
$dsn = 'mysql:dbname=teishoku;host=localhost';
$user = 'root';

// ページ遷移設定
if (!empty($_SESSION['username'])) {
    print 'ウェルカム'.$_SESSION['username'];
} else {
    if (!empty($_POST['_submit_check'])) {
        if ($form_errors = validate_form()) {
            show_form($form_errors);
        } else {
            show_menu();
            process_form();
        }
    } else {
        show_menu();
        show_form();
    }
}

function show_menu() {
    global $db, $dsn, $user;
    try {
        $db = new PDO($dsn, $user);
    } catch (PDOException $e) {
        print 'DB Connection failed:'.$e->getMessage();
        die;
    }
    $sql1 = 'SELECT name, price FROM menu';
    $sql2 = 'SELECT name FROM source';
    $menu = $db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
    $source = $db->query($sql2)->fetchAll(PDO::FETCH_COLUMN);
    print '<table border="1">';
    print '<tr><th>メニュー</th><th>値段</th></tr>';
    foreach ($menu as $menu) {
        print '<tr>';
        print '<td>'.$menu['name'].'</td><td>'.$menu['price'].'</td>';
        print '</tr>';
    }
    print '</table>';
    print '唐揚げにはソースをつけられます。（各100円）<ul>';
    foreach ($source as $source) {
        print '<li>'.$source.'ソース</li>';
    }
    print '</ul>';
}
// フォーム表示関数
function show_form($errors = '') {
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    
    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }
    foreach ()
    input_radiocheck('radio', $element_name, $values, $element_value)
    
    
    input_submit('submit', '会計');
    
    print '<input type="hidden" name="_submit_check" value="1">';
    print '</form>';
}

// 提出された値をチェックする関数
function validate_form() {
    global $db, $dsn, $user;
    try {
        $db = new PDO($dsn, $user);
    } catch (PDOException $e) {
        print 'DB Connection failed:'.$e->getMessage();
        die;
    }
    $errors = array();
    $sql = 'SELECT username, password FROM user_list';
    $users = $db->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
    
    if (! array_key_exists($_POST['username'], $users)) {
        $errors[] = 'ユーザー名、パスワードが間違っています。';
    }
    
    $saved_password = $users[$_POST['username']];
    if ($saved_password != $_POST['password']) {
        $errors[] = 'ユーザー名、パスワードが間違っています。';
    }
    return $errors;
}

// 提出された値が適切な時の処理関数
function process_form() {
    $_SESSION['username'] = $_POST['username'];
    print "ようこそ $_SESSION[username]";
}
?>