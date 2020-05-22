<?php

require_once 'teishoku.class.php';

$teishoku = new Teishoku();

echo '<pre>';
var_dump($_POST);
echo '</pre>';

$teishoku->show_menu();
if (!empty($_POST['errors'])) {
    $teishoku->show_form('redirect.php', $_POST['errors']);
} else {
    $teishoku->show_form('redirect.php');
}
?>