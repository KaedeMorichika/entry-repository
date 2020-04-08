<?php
print '<html>';
function web_color($red, $green, $blue) {
    $red = dechex($red);
    $green = dechex($green);
    $blue = dechex($blue);

    return '#'.$red.$green.$blue;
}

$bgcolor = web_color(120, 0, 0);
print "<body bgcolor=\"$bgcolor\"></body>";
print '</html>';

?>