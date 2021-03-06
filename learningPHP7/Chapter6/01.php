<?php
class Human {
    public $name;
    public $height;
    public $weight;
    
    public function __construct($name, $height, $weight) {
        $this->name = $name;
        $this->height = $height;
        $this->weight = $weight;
    }
    
    public function calcBMI () {
        $height = $this->height/100;
        $weight = $this->weight;
        return $weight / $height / $height;
    }
    
    public function idealBMI () {
        return 22;
    }
}

class Group extends Human {
    public $group = array();
    
    public function __construct($humans) {
        
        $this->group = $humans;
        foreach ($this->group as $human) {
            if (! $human instanceof Human) {
                throw new Exception('Not a human.');
            }
        }
    }
    
    public function show_table () {
        print '<table border="1"><tr><th>名前</th><th>身長（cm）</th><th>体重（kg）</th><th>BMI</th></tr>';
        foreach ($this->group as $human) {
            print '<tr>';
            foreach ($human as $item) {
                print '<td>'.$item.'</td>';
            }
            print '<td>'.$human->calcBMI().'</td></tr>';
        }
        print '</table>';
    }
    
    public function add_member ($member) {
        $this->group[] = $member;
    }
    
    public function names () {
        $names = array();
        foreach ($this->group as $human) {
            $names[] = $human->name;
        }
        return $names;
    }
    
    public function calc_average () {
        $num = count($this->group);
        $height = 0;
        $weight = 0;
        $bmi = 0;
        foreach ($this->group as $human) {
            $height += $human->height;
            $weight += $human->weight;
            $bmi += $human->calcBMI();
        }
        return array('height'=>$height/$num, 'weight'=>$weight/$num, 'bmi'=>$bmi/$num);
    }
}

$bob = new Human('Bob', '183', 75);
print $bob->name . 'さん　' . $bob->height . 'cm　' . $bob->weight . 'kg';
print '<br>';
print 'BMI　' . $bob->calcBMI();
print '<br>';
print '理想BMI　' . Human::idealBMI();
print '<br>';

$jordan = new Human('Jordan', 195, 90);
$shaq = new Human('Shaq', 217, 130);
$lebron = new Human('LeBron', 203, 110);

$group = new Group(array($bob, $jordan, $shaq));
foreach ($group->names() as $name) {
    print $name.'<br>';
}
$group->add_member($lebron);
foreach ($group->names() as $name) {
    print $name.'<br>';
}
$group->show_table();
$average = $group->calc_average();
print '平均身長　' . $average['height'] . 'cm<br>';
print '平均体重　' . $average['weight'] . 'kg<br>';
print 'BMI　' . $average['bmi'];

?>