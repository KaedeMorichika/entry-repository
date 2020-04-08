<?php
print '<html><body>';

function image($path, $alt = '', $height = '', $width = '') {
    print "<img src=\"$path\"";

    if ($alt) print " alt = \"$alt\"";
    if ($height) print " height = \"$height\"";
    if ($width) print " width = \"$width\"";

    print '>';
}

$path = 'images\147421m.jpg';
$alt = 'イメージ';
$height = 128;
$width = 128;

image($path);
print '<br>';
image($path, $alt);
print '<br>';
image($path, $alt, $height);
print '<br>';
image($path, $alt, $height, $width);

print '</body></html>';
?>