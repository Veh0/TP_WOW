<?php



include_once('init.php');


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    if (isset($_POST['player'])) $player = $GLOBALS[strtolower($_POST['player'])];

    if (isset($_POST["player"]) && isset($_POST["playerItems"])) fight($_POST["player"], json_decode($_POST["playerItems"], true));

    
    switch($action) {
        case 'ajaxGetDamage' : 
            ajaxGetDamage($player, $_POST['hp'],$_POST['damage'], $_POST['stamina'], $_POST['defense']);
        break;
        case 'ajaxAttack':
            ajaxAttack($player, $_POST['stamina']);
        break;
        case 'ajaxEat':
            ajaxEat($player, $_POST['stamina']);
        break;
        case 'ajaxPlayerDeath' : 
            ajaxPlayerDeath($player);
        break;
        // ...etc...
    }
}

function ajaxEat($character, $stamina) {
    $character->setStamina($stamina);

    $character->eat();

    echo $character->getStamina();
}

function ajaxAttack($character, $stamina) {
    $character->setStamina($stamina);

    $character->attack();

    echo $character->getStamina();
}

function ajaxGetDamage($character, $hp, $damage, $stamina, $defense) {
    $character->setHp($hp);
    $character->setStamina($stamina);

    $tab = [];

    if ($defense) {
        # code...
        $character->defense($damage);
    } else {
        # code...
        $character->getDamage($damage);
    }
    
    $tab["hp"] = round($character->getHP());
    $tab["stamina"] = $character->getStamina();

    echo json_encode($tab);
    //return json_encode($character->getHp());
}

function ajaxPlayerDeath($character) {
    echo $character->getName();
}

function fight($player, $playerItems) {


    $character = $GLOBALS[strtolower($player)];
    $character->setInventory($playerItems, "add");
    foreach ($playerItems as $key => $value) {
        # code...
        switch (key($value)) {
            case 'weapon':
                # code...
                $weapon = $GLOBALS[strtolower($value["weapon"])];
                if($character->getWeapon() == "No weapon") $character->setWeapon($weapon);
                break;
            case 'shield':
                # code...
                $shield = $GLOBALS[strtolower($value["shield"])];
                if($character->getShield() == "No shield") $character->setShield($shield);
                break;
            
            case 'food':
                # code...
                $food = $GLOBALS[strtolower($value["food"])];
                if($character->getFood() == "No food") $character->setFood($food);
                break;
            default:
                continue;
            break;
        }
    }

    
    }

    
