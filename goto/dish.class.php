<?php 
class Dish {
    
    protected $name;
    protected $price;
    
    public function __construct($name, $price) {
        
        $this->name = $name;
        $this->price = $price;
        
    }
    
    public function showExplain(){
        
        print $this->getName().$this->getPrice();
    }
    
    public function showOption(){
        
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    
    
}

?>