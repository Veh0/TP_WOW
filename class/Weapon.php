<?php

abstract class Weapon {

    public function __construct($name, $damage, $height, $weight)
    {
        $this->name = $name;
        $this->damage = $damage;
        $this->height = $height;
        $this->weight = $weight;
    }

    // SETTERS
    public function setName($name) {
        $this->name = $name;
    }

    public function setDamage($damage) {
        $this->damage = $damage;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    // GETTERS
    public function getName() {
        return $this->name;
    }

    public function getDamage() {
        return $this->damage;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWeight() {
        return $this->weight;
    }

}