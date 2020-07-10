<?php

abstract class Character {

    public $name;
    public $hp;
    public $stamina;
    public $inventory = [];
    public $weapon;
    public $shield;
    public $food;

    public function __construct($name, $hp, $stamina) {
        $this->name = $name;
        $this->hp = $hp;
        $this->stamina = $stamina;
        $this->weapon = "No weapon";
        $this->shield = "No shield";
        $this->food = "No food";
    }

    // SETTERS
    public function setName($name) {
        $this->name = $name;
    }

    public function setHp($hp) {
        $this->hp = $hp;
    }

    public function setStamina($stamina) {
        $this->stamina = $stamina;
    }

    public function setWeapon($weapon) {
        $this->weapon = $weapon;
    }

    public function setShield($shield) {
        $this->shield = $shield;
    }

    public function setFood(Food $food) {
        $this->food = $food;
    }

    public function setInventory($item, $action) {
        switch ($action) {
            case 'add':
                # code...
                $this->inventory = $item;
                break;
            
            case 'remove':
                # code...
                break;
        }
    } 

    // GETTERS
    public function getName() {
        return $this->name;
    }

    public function getHp() {
        return $this->hp;
    }

    public function getStamina() {
        return $this->stamina;
    }

    public function getWeapon() {
        return $this->weapon;
    }

    public function getShield() {
        return $this->shield;
    }

    public function getFood() {
        return $this->food;
    }

    public function getInventory() {
        return $this->inventory;
    }

    // FUNCTIONS
    public function attack() {
        $stamina = $this->getStamina();
        $stamina = $stamina - ($this->weapon->getHeight() * $this->weapon->getWeight())/10000;
        $this->setStamina($stamina); 

    }

    public function getDamage($damage) {
        $this->hp -= $damage;
    }

    public function eat() {
        $this->stamina += $this->food->stamina;
    }

    public function defense($damage) {
        if($this->getShield() == "No shield") {
            $damage = $damage;
        } else {
            $damageReduce = $damage * $this->shield->getPercentDefense()/100;
            $damage = $damage - $damageReduce;
        }
        $stamina = $this->getStamina();
        $this->getShield() == "No shield" ? $stamina = $stamina : $this->setStamina($stamina - $this->shield->getWeight()/100); 
        $this->getDamage($damage);
    }

}