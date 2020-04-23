<?php
$dsn = 'mysql:dbname=octech;host=localhost';
$user = 'root';
$psw = 'db090902';
try {
    $db = new PDO($dsn, $user, $psw);
} catch (PDOException $e) {
    print 'DB Connection failed:'.$e->getMessage();
    die;
}

if (! empty($_POST['_submit_check'])){
    $sql = 'SELECT * FROM food WHERE name="きゅうり"';
    $db->query($sql);
} else {
print '<form method="POST" action='. $_SERVER['PHP_SELF'] . '">';
print <<< __text__
<input type="text" name="food">
<input type="hidden" name="_submit_check" value="1">
<input type="submit" value="submit">
__text__;
}
?>