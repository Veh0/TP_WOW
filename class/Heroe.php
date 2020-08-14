<?php

include_once("Character.php");

class Heroe extends Character {

    public function __construct($name, $hp, $stamina, $strength)
    {
        parent::__construct($name, $hp, $stamina, $strength);
    }

}