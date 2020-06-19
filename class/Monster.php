<?php

include_once("Character.php");

class Monster extends Character {

    public function __construct($name, $hp)
    {
        parent::__construct($name, $hp);
    }

    public function attack()
    {
        echo $this->name." stunned the Heroe!";
    }

    public function getDamage($damage)
    {
        $this->hp = $this->hp - $damage;
    }

}