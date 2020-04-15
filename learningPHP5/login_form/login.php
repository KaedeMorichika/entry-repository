<?php 
// フォームヘルパー関数のインポート
require 'form_helper.php';

// パスワード
function input_password($field_name, $values) {
    print '<input type="password" name="'.$field_name;
    if (array_key_exists($field_name, $values)) {
        print ' value="'.htmlentities($values[$field_name]);
    }
    print '"/>';
}

// セッションの開始
session_start();

// DBの設定
$dsn = 'mysql:dbname=db0415;host=localhost';
$user = 'root';

// ページ遷移設定
if (!empty($_SESSION['username'])) {
    print 'ウェルカム'.$_SESSION['username'];
} else {
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

// フォーム表示関数
function show_form($errors = '') {
    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
    
    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }
    print 'Username: ';
    input_text('username', $_POST);
    print '<br>';
    
    print 'Password: ';
    input_password('password', $_POST);
    print '<br>';
    
    input_submit('submit', 'ログイン');
    
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