<?php



include_once('init.php');


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    if (isset($_POST['player'])) $player = $GLOBALS[strtolower($_POST['player'])];
    if (isset($_POST['enemy'])) $enemy = $GLOBALS[strtolower($_POST['enemy'])];

    if (isset($_POST["player"]) && isset($_POST["playerItems"])) fight($_POST["player"], json_decode($_POST["playerItems"], true));
    
    switch($action) {
        case 'ajaxGetDamage' : 
            ajaxGetDamage($player, $_POST['hp'],$_POST['damage'], $_POST['stamina']);
        break;
        case 'ajaxAttack':
            ajaxAttack($player, $_POST['stamina'], $_POST["coord"], $_POST["enemyCoord"]);
        break;
        case 'ajaxEat':
            ajaxEat($player, $_POST['stamina']);
        break;
        case 'ajaxPlayerDeath' : 
            ajaxPlayerDeath($player);
        break;
        case 'ajaxChangeItem':
            ajaxChangeItem($player, $_POST['type'], $_POST['item']);
        break;
        case 'ajaxMove':
            ajaxMove($player, $enemy, $_POST["enemyCoord"], $_POST["originCoordinate"], $_POST["direction"], $_POST["stamina"]);
        break;
        case 'ajaxSleep':
            ajaxSleep($player, $_POST["stamina"], $_POST["hp"]);
        break;
        case 'ajaxRunAway':
            ajaxRunAway($player, $enemy, $_POST["enemyCoord"], $_POST["originCoordinate"], $_POST["stamina"]);
        break;
        // ...etc...
    }
}

function ajaxEat($character, $stamina) {
    $character->setStamina($stamina);

    $character->eat();

    if ($character->getStamina() > $character->getStaminaMax()) {
        # code...
        $tab["error"] = 1;
        $character->setStamina($character->getStaminaMax());
    } else {
        $tab["error"] = 0;
    }

    $tab["stamina"] = $character->getStamina();

    echo json_encode($tab);
}

function ajaxSleep($character, $stamina, $hp) {
    $character->setStamina($stamina);
    $character->setHp($hp);

    $character->sleep();

    if($character->getStamina() >= $character->getStaminaMax() && $character->getHp() >= $character->getHpMax()) {
        $tab["error"] = 3;
        $character->setStamina($character->getStaminaMax());
        $character->setHp($character->getHpMax());
    } else if($character->getHp() > $character->getHpMax()) {
        $tab["error"] = 2;
        $character->setHp($character->getHpMax());
    } else if ($character->getStamina() > $character->getStaminaMax()) {
        # code...
        $tab["error"] = 1;
        $character->setStamina($character->getStaminaMax());
    } else {
        $tab["error"] = 0;
    }

    $tab["stamina"] = $character->getStamina();
    $tab["hp"] = $character->getHp();

    echo json_encode($tab);
}

function ajaxAttack($character, $stamina, $coord, $enemyCoord) {
    $character->setStamina($stamina);

    if((intval($coord[0]) == intval($enemyCoord[0]) && (intval($coord[1]) == intval($enemyCoord[1]) - 1 || intval($coord[1]) == intval($enemyCoord[1]) + 1)) || (intval($coord[1]) == intval($enemyCoord[1]) && (intval($coord[0]) == intval($enemyCoord[0]) - 1 || intval($coord[0]) == intval($enemyCoord[0]) + 1))) {
        # code...
        $character->attack();
        $tab["error"] = 0;
    } else {
        $tab["error"] = 1;
        $character->setStamina($stamina);
    }

    if($character->getStamina() < 0) {
        $character->setStamina($stamina);
        $tab["error"] = 2;
    }
    $tab["stamina"] = $character->getStamina();

    echo json_encode($tab);
}

function ajaxMove($character, $enemy, $enemyCoord, $originCoord, $direction, $stamina) {
        

    $character->setCoordinate($originCoord);
    $enemy->setCoordinate($enemyCoord);

    $character->setStamina($stamina);

    $charge = 0;
        for ($i=0; $i < count($character->getInventory()); $i++) { 
            # code...
            $item = $character->getInventory()[$i];
            foreach($item as $key => $value) {
                if($key == "food") continue;
                $charge += $GLOBALS[strtolower($value)]->getWeight();
            }
        }

    $character->move($direction, $charge);

    $array = array_diff_assoc($character->getCoordinate(), $enemy->getCoordinate());

    if (empty($array) || $character->getCoordinate()[0] == 10 || $character->getCoordinate()[0] < 0 || $character->getCoordinate()[1] == 10 || $character->getCoordinate()[1] < 0) {
        # code...
        $tab["error"] = 1;
        $character->setCoordinate($originCoord);
        $character->setStamina($stamina);
    } else {
        $tab["error"] = 0;
    }

    if($character->getStamina() < 0) {
        $tab["error"] = 2;
        $character->setCoordinate($originCoord);
        $character->setStamina($stamina);
    }

    $tab["stamina"] = $character->getStamina();

    $tab["coord"] = $character->getCoordinate();

    echo json_encode($tab);
}

function ajaxRunAway($character, $enemy, $enemyCoord, $originCoord, $stamina) {

    $character->setCoordinate($originCoord);
    $enemy->setCoordinate($enemyCoord);

    $character->setStamina($stamina);

    $charge = 0;
        for ($i=0; $i < count($character->getInventory()); $i++) { 
            # code...
            $item = $character->getInventory()[$i];
            foreach($item as $key => $value) {
                if($key == "food") continue;
                $charge += $GLOBALS[strtolower($value)]->getWeight();
            }
        }

    $arrayDir = ["nord", "sud", "est", "ouest"];

    $error = 1;
    $i = 0;
    while($error == 1) {
        $direction = $arrayDir[$i];
        $character->move($direction, $charge);

        $array = array_diff_assoc($character->getCoordinate(), $enemy->getCoordinate());

        if (!empty($array) && $character->getCoordinate()[0] < 10 && $character->getCoordinate()[0] > 0 && $character->getCoordinate()[1] < 10 && $character->getCoordinate()[1] > 0) {
            # code...
            $character->move($direction, $charge);
            $array = array_diff_assoc($character->getCoordinate(), $enemy->getCoordinate());
            
            if (!empty($array) && $character->getCoordinate()[0] < 10 && $character->getCoordinate()[0] > 0 && $character->getCoordinate()[1] < 10 && $character->getCoordinate()[1] > 0) {
                $error = 0;
            } else {
                $character->setCoordinate($originCoord);
                $character->setStamina($stamina);
                $error = 1;
                $i++;
            }
        } else {
            $character->setCoordinate($originCoord);
            $character->setStamina($stamina);
            $error = 1;
            $i++;
        }

    }

    $tab["error"] = 0;

    if($character->getStamina() < 0) {
        $tab["error"] = 1;
        $character->setCoordinate($originCoord);
        $character->setStamina($stamina);
    }

    $tab["coord"] = $character->getCoordinate();
    $tab["stamina"] = $character->getStamina();

    echo json_encode($tab);
}


function ajaxGetDamage($character, $hp, $damage, $stamina) {
    $character->setHp($hp);
    $character->setStamina($stamina);

    $tab = [];

    # code...
    $character->defense($damage);

    var_dump($character->getShield()->getWeight());

    $tab["error"] = 0;

    if($character->getStamina() < 0) {
        $character->setHp($hp);
        $character->setStamina($stamina);
        $tab["error"] = 1;

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

function ajaxChangeItem($character, $type, $item) {

    switch ($type) {
        case 'weapon':
            # code...
            $tab = [];
            $weapon = $GLOBALS[strtolower($item)];
            $character->setWeapon($weapon);
            $tab["name"] = $weapon->getName();
            $tab["damage"] = $weapon->getDamage();
            echo json_encode($tab);
        break;
        case 'shield':
            # code...
            $shield = $GLOBALS[strtolower($item)];
            $character->setShield($shield);
            $tab["name"] = $shield->getName();
            $tab["percentDefense"] = $shield->getPercentDefense();
        break;
        case 'food':
            # code...
            $food = $GLOBALS[strtolower($item)];
            $character->setFood($food);
        break;
    }

    
}

function fight($character, $playerItems) {

    if (!is_object($character)) {
        # code...
        $character = $GLOBALS[strtolower($character)];
    }
    
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

    
