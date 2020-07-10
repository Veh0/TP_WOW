<?php  

class Shield {

    public $percentDefense;
    public $name;
    public $weight;

    public function __construct($name, $percentDefense, $weight) {
        $this->name = $name;
        $this->percentDefense = $percentDefense;
        $this->weight = $weight;
    }

    // SETTERS
    public function setName($name) {
        $this->name = $name;
    }

    public function setPercentDefense($percent) {
        $this->percentDefense = $percent;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    // GETTTERS
    public function getName() {
        return $this->name;
    }

    public function getPercentDefense() {
        return $this->percentDefense;
    }

    public function getWeight() {
        return $this->weight;
    }

}