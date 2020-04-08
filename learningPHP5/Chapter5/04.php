<?php
print '<html><body>';

$path = 'images\\';

function image($image, $alt = '', $height = '', $width = '') {
    $url = $GLOBALS['path'].$image;
    print "<img src=\"$url\"";

    if ($alt) print " alt = \"$alt\"";
    if ($height) print " height = \"$height\"";
    if ($width) print " width = \"$width\"";

    print '>';
}

$image = '147421m.jpg';
$alt = 'イメージ';
$height = 128;
$width = 128;

image($image);
print '<br>';
image($image, $alt);
print '<br>';
image($image, $alt, $height);
print '<br>';
image($image, $alt, $height, $width);

print '</body></html>';
?>
