<?php
require_once 'CommonFunction.php';
require_once 'dish.class.php';

class Karaage extends Dish {
    
    private $source;
    
    public function showOption(){
        print "からあげにはソースがつきますよん";
    }
    
    
}