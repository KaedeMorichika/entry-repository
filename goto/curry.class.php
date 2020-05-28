<?php
require_once 'CommonFunction.php';
require_once 'dish.class.php';

class Curry extends Dish {
    
    public function showOption(){
        print "からさが選べます";
    }
    
    
}