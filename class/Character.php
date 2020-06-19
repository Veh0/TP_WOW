<?php

abstract class Character {

    public $weapon;

    public function __construct($name, $hp)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->weapon = "No weapon";
    }

    // SETTERS
    public function setName($name) {
        $this->name = $name;
    }

    public function setHp($hp) {
        $this->hp = $hp;
    }

    public function setWeapon($weapon) {
        $this->weapon = $weapon;
    }

    // GETTERS
    public function getName() {
        return $this->name;
    }

    public function getHp() {
        return $this->hp;
    }

    public function getWeapon() {
        return $this->weapon;
    }

    // FUNCTIONS
    abstract function attack();

    abstract function getDamage(Character $character);

}