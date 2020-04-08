<?php
function page_header($color) {
    print '<html><head><title>Welcome to my site</title></head>';
    print '<body bgcolor = "#'.$color.'">';
}

function countdown($top) {
    while ($top > 0) {
        print "$top..";
        $top--;
    }
    print 'boom!<br>';
}

page_header('ffffff');


$counter = 5;
countdown($counter);
print "Now, counter is $counter";

print '</body></html>';
?>

