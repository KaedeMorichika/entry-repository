<?php
$dinner = 'Curry Cuttlefish';

function macrobiotic_dinner() {
    global $dinner;
    $dinner = 'Some vegetables';
    print "Dinner is $dinner";

    print ' but I\'d rather have ';
    print $dinner;
    print '<br>';
}

macrobiotic_dinner();
print "Regular dinner is: $dinner";
?>