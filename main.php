<?php

include("class/Heroe.php");
include("class/Sword.php");
include("class/Monster.php");
include("class/Club.php");

$heroe = new Heroe("Uther", 50);
$sword = new Sword("Ligntbringer", 15, 100, 850);
$heroe->setWeapon($sword);


$monster = new Monster("Thrall", 60);
$club = new Club("Doomhammer", 11, 80, 1250);
$monster->setWeapon($club);


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'ajaxGetDamage' : 
            $_POST['player'] == 1 ? ajaxGetDamage($heroe, $_POST['hp'],$_POST['damage']) : ajaxGetDamage($monster, $_POST['hp'],$_POST['damage']); ;
        break;
        case 'ajaxPlayerDeath' : 
            $_POST['player'] == 1 ? ajaxPlayerDeath($heroe) : ajaxPlayerDeath($monster); ;
        break;
        // ...etc...
    }
}

function ajaxGetDamage($character, $hp, $damage) {
    $character->setHp($hp);
    $character->getDamage($damage);
    echo $character->getHP();
    //return json_encode($character->getHp());
}

function ajaxPlayerDeath($character) {
    echo $character->getName();
}