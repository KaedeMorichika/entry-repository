<?php 
class Dish {
    
    protected $id;
    protected $name;
    protected $price;
    protected $with_sauce;
    protected $sauces;
    
    public function __construct($id, $name, $price, $with_sauce = 0, $sauces = null) {
        
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->with_sauce = $with_sauce;
        
        if ($with_sauce == 1) {
            $this->sauces = $sauces;
        }
        
    }
    
    public function getID () {
        return $this->id;
    }
    
    public function getName () {
        return $this->name;
    }
    
    public function getPrice () {
        return $this->price;
    }
    
    public function getWithSauce () {
        return $this->with_sauce;
    }
    
    public function getSauces () {
        return $this->sauces;
    }
    
    public function setSauces ($sauces) {
        
        if ($this->with_sauce === 1) {
            
            if (! empty($sauces)) {
                
                $this->sauces = $sauces;
                $this->with_sauce = 1;
            }
            
            return true;
        } else {
            
            return false;
        }
        
    }
    
}

?>