<?php

include("class/Heroe.php");
include("class/Sword.php");
include("class/Monster.php");
include("class/Club.php");

// HEROES
$uther = new Heroe("Uther", 110);
$lightbringer = new Sword("Ligntbringer Hammer", 15, 100, 850);
$uther->setWeapon($lightbringer);

$jaina = new Heroe("Jaina", 95);
$staff = new Sword("Staff of Antonidas", 17, 140, 650);
$jaina->setWeapon($staff);

$sonya = new Heroe("Sonya", 85);
$twinswords = new Sword("Twin Swords", 20, 60, 300);
$sonya->setWeapon($twinswords);

$heroes = [$uther, $jaina, $sonya];
$actifHeroe;

// MONSTERS
$thrall = new Monster("Thrall", 120);
$doomhammer = new Club("Doomhammer", 13, 80, 1250);
$thrall->setWeapon($doomhammer);

$sylvanas = new Monster("Sylvanas", 100);
$bow = new Club("Windrunner's Bow", 16, 120, 2250);
$sylvanas->setWeapon($bow);

$illidan = new Monster("Illidan", 90);
$twinblades = new Club("Twin Blades of Azzinoth", 18, 100, 750);
$illidan->setWeapon($twinblades);

$monsters = [$thrall, $sylvanas, $illidan];
$actifMonster;


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    if (isset($_POST['player'])) $player = $_POST['player'];
    
    switch($action) {
        case 'ajaxGetDamage' : 
            ajaxGetDamage($$player, $_POST['hp'],$_POST['damage']);
        break;
        case 'ajaxPlayerDeath' : 
            ajaxPlayerDeath($$player);
        break;
        case 'ajaxFight' :
            ajaxFight($_POST['heroe'], $_POST['monster']);
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

function ajaxFight($heroe, $monster) {
    $heroe = strtolower($heroe);
    $monster = strtolower($monster);
    
    $url = 'fight.php?heroe='.$heroe.'&monster='.$monster;
    echo $url;
}