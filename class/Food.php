<?php

class Food {

    public $name;
    public $stamina;

    public function __construct($name, $stamina) {
        $this->name = $name;
        $this->stamina = $stamina;
    }

    // SETTERS
    public function setname($name) {
        $this->name = $name;
    }

    public function setStamina($stamina) {
        $this->stamina= $stamina;
    }

    // GETTERS
    public function getname() {
        return $this->name;
    }

    public function getStamina() {
        return $this->stamina;
    }

}