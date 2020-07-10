<?php

include_once("Weapon.php");

class Sword extends Weapon {

    public function __construct($name, $damage, $height, $weight) {
        parent::__construct($name, $damage, $height, $weight);
    }

}