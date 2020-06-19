<?php

include_once("Character.php");

class Heroe extends Character {

    public function __construct($name, $hp)
    {
        parent::__construct($name, $hp);
    }

    public function attack()
    {
        echo $this->name." slayed his ennemy!";
    }

    public function getDamage($damage)
    {
        $this->hp = $this->hp - $damage;
    }

}