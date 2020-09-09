<?php
$text = '<><>あいうo&';
print $text.'<br>';
$after = htmlspecialchars($text);
print $after.'<br>';

?>