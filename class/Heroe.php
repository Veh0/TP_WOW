<?php

include_once("Character.php");

class Heroe extends Character {

    public function __construct($name, $hp, $stamina)
    {
        parent::__construct($name, $hp, $stamina);
    }

}