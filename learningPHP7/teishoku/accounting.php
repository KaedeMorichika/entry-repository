<?php 
require 'teishoku.class.php';

$teishoku = new Teishoku();

$teishoku->show_menu();

$teishoku->show_accounting($_POST);
?>