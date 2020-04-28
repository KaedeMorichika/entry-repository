<?php
// MySQL接続のための定数設定
$dsn = 'mysql:dbname=dbhoge;host=localhost';
$user = 'root';
$psw = 'psw2';

// DB接続
try {
    $db = new PDO($dsn, $user, $psw);
} catch (PDOException $e) {
    print 'DB Connection failed:'.$e->getMessage();
    die;
}
?>