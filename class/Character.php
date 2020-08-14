<?php

abstract class Character {

    public $name;
    public $hp;
    public $hpMax;
    public $stamina;
    public $staminaMax;
    public $strength;
    public $charge;
    public $inventory = [];
    public $coordinate = [];
    public $weapon;
    public $shield;
    public $food;

    public function __construct($name, $hp, $stamina, $strength) {
        $this->name = $name;
        $this->hp = $hp;
        $this->hpMax = $hp;
        $this->stamina = $stamina;
        $this->staminaMax = $stamina;
        $this->strength = $strength;
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

    public function setCoordinate(array $coordinate) {
        $this->coordinate = $coordinate;
    }

    // GETTERS
    public function getName() {
        return $this->name;
    }

    public function getHp() {
        return $this->hp;
    }

    public function getHpMax() {
        return $this->hpMax;
    }

    public function getStamina() {
        return $this->stamina;
    }

    public function getStaminaMax() {
        return $this->staminaMax;
    }

    public function getStrength() {
        return $this->strength;
    }

    public function getCharge() {
        return $this->charge;
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

    public function getCoordinate() {
        return $this->coordinate;
    }

    // FUNCTIONS
    public function attack() {
        $stamina = $this->getStamina();
        if($this->weapon != "No weapon") $stamina = round($stamina - ($this->weapon->getHeight() * $this->weapon->getWeight())/(1000 * $this->getStrength()), 1);
        $this->setStamina($stamina); 

    }

    public function getDamage($damage) {
        $this->hp -= $damage;
    }

    public function sleep() {
        $this->hp += ($this->getHpMax()*10)/100;
        $this->stamina += ($this->getStaminaMax()*5)/100;
    }

    public function move($direction, $charge) {
        
        $x = $this->getCoordinate()[0];
        $y = $this->getCoordinate()[1];
        
        switch ($direction) {
            case 'nord':
                # code...
                $y = $y + 1;
            break;    
            case 'sud':
                # code...
                $y = $y - 1;
            break;  
            case 'ouest':
                # code...
                $x = $x - 1;
            break; 
            case 'est':
                # code...
                $x = $x + 1;
            break;   
        }

        $stamina = $this->getStamina();
        $this->setStamina(round($stamina - $charge/(10 * $this->getStrength()), 1));

        $this->setCoordinate([$x, $y]);
    }

    public function eat() {
        if($this->food != "No food") $this->stamina += $this->food->stamina;
    }

    public function defense($damage) {
        if($this->getShield() == "No shield") {
            $damage = $damage;
        } else {
            $damageReduce = $damage * $this->shield->getPercentDefense()/100;
            $damage = $damage - $damageReduce;
        }
        $stamina = $this->getStamina();
        if($this->getShield() != "No shield") $this->setStamina(round($stamina - $this->shield->getWeight()/(100 * $this->getStrength()), 1)); 
        $this->getDamage($damage);
    }

}