<?php
$students =array(
    'taro' => array('grade' => 'A+', 'id' => 1111),
    'jiro' => array('grade' => 'A', 'id' => 1112),
    'subro' => array('grade' => 'C', 'id' => 1113),
    'shiro' => array('grade' => 'F', 'id' => 1114),
    );
foreach($students as $student => $info ) {
    print '名前 '.$student;
    foreach($info as $key => $value) {
        if ($key == 'grade') {
            print ' 成績 '.$value;
        } elseif ($key == 'info') {
            print ' ID '.$value;
        }
    }
    print '<br>';
}

print '<br>';

$zaiko = array(
    'apple' => 15,
    'orange' => 21,
    'banana' => 11,
    'grape' => 5
);

foreach ($zaiko as $item => $number) {
    print '商品 '.$item.' 在庫 '.$number.'<br>';
}

print '<br>';

$kondate = array(
    'monday' => array('menu' => 'noodle', 'price' => 255),
    'tuesday' => array('menu' => 'bread', 'price' => 165),
    'wendsday' => array('menu' => 'rice', 'price' => 125),
    'thursday' => array('menu' => 'noodle', 'price' => 255),
    'friday' => array('menu' => 'rice', 'price' => 125)
);

$sum = 0;

foreach($kondate as $day => $info) {
    print $day;
    foreach ($info as $key => $value) {
        if ($key == 'menu') {
            print ' 献立 '.$value;
        } elseif ($key == 'price') {
            $sum += $value;
            print ' 費用 '.$value;
        }
    }
    print '<br>';
}
print '<br>';
print '合計費用 '.$sum;

print '<br>';

$family = array('mother', 'grandfather', 'brother', 'sister');
foreach($family as $value) {
    print $value.'<br>';
}
?>