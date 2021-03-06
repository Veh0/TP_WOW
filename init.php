<?php

include("class/Heroe.php");
include("class/Food.php");
include("class/Shield.php");
include("class/Sword.php");
include("class/Monster.php");
include("class/Club.php");

// HEROES
$uther = new Heroe("Uther", 110, 90, 20);

$jaina = new Heroe("Jaina", 95, 100, 12);

$sonya = new Heroe("Sonya", 85, 115, 17);

$heroes = [$uther, $jaina, $sonya];
$actifHeroe;

// MONSTERS
$thrall = new Monster("Thrall", 120, 85, 21);

$sylvanas = new Monster("Sylvanas", 100, 95, 14);

$illidan = new Monster("Illidan", 90, 120, 15);

$monsters = [$thrall, $sylvanas, $illidan];
$actifMonster;

// WEAPONS
$lightbringer = new Sword("Lightbringer", 15, 100, 850);
$doomhammer = new Club("Doomhammer", 13, 80, 1250);
$excalibur = new Sword("Excalibur", 11, 120, 1325);
$mjolnir = new Club("Mjolnir", 14, 95, 1500);

$weapons = [$lightbringer, $doomhammer, $excalibur, $mjolnir];

// SHIELD
$ecu = new Shield("Ecu", 20, 900);
$rempart = new Shield("Rempart", 35, 1200);

$shields = [$rempart, $ecu];

// FOOD
$meat = new Food("Meat", 7.5);
$bread = new Food("Bread", 5);

$foods = [$meat, $bread];