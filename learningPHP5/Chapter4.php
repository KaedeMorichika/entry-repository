<?php
$populations = array(
    'New York' => 8008278,
    'Los Angeles' => 3694820,
    'Chicago' => 2896016,
    'Houston' => 1953631,
    'Philadelphia' => 1517550,
    'Phoenix' => 1321045,
    'San Diego' => 1223400,
    'Dallas' => 1188580,
    'San Antonio' => 1144646,
    'Detroit' => 951270
);

foreach($populations as $city => $population) {
    print '都市：'.$city."　人口：".$population.'<br>';
}

print '<br>';
asort($populations);

foreach($populations as $city => $population) {
    print '都市：'.$city."　人口：".$population.'<br>';
}

print '<br>';
ksort($populations);

foreach($populations as $city => $population) {
    print '都市：'.$city."　人口：".$population.'<br>';
}


print '<br>';

$city_info = array(
    'New York' => array('NY', 8008278),
    'Los Angeles' => array('CA', 3694820),
    'Chicago' => array('IL', 2896016),
    'Houston' => array('TX', 1953631),
    'Philadelphia' => array('PA', 1517550),
    'Phoenix' => array('AZ', 1321045),
    'San Diego' => array('CA', 1223400),
    'Dallas' => array('TX', 1188580),
    'San Antonio' => array('TX', 1144646),
    'Detroit' => array('MI', 951270)
);

$state_populations = array();


foreach($city_info as $city => $info) {
    $flag_of_add_data = 1;
    foreach ($state_populations as $state => $population) {
            if ($state == $info[0]) {
                $state_populations[$state] += $info[1];
                $flag_of_add_data = 0;
            } else {
                continue;
            }
    }
    if ($flag_of_add_data == 1) {
        $state_populations[$info[0]] = $info[1];
    }
}

foreach($state_populations as $state => $population) {
    print '州：'.$state.'　人口：'.$population.'<br>';
}


?>