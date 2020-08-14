<?php 

        include_once('main.php'); 
        
        fight($_POST["heroe"], json_decode($_POST["heroeItems"], true)); 
        fight($_POST["monster"], json_decode($_POST["monsterItems"], true));

        $heroe = $GLOBALS[strtolower($_POST["heroe"])];
        $monster = $GLOBALS[strtolower($_POST["monster"])];

        //var_dump($heroe);
        $charge = 0;
        for ($i=0; $i < count($heroe->getInventory()); $i++) { 
            # code...
            $item = $heroe->getInventory()[$i];
            foreach($item as $key => $value) {
                if($key == "food") continue;
                $charge += $GLOBALS[strtolower($value)]->getWeight();
            }
        }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
    <title>TP_WOW</title>
</head>
<body>
    

    <a class="waves-effect waves-light button grey darken-3 modal-trigger" style="width:10%; margin:0; float: right" href="#modal-cemetery">Cemetery</a>
    <a href="index.php" class="button" style="width:10%; margin:0;">Back</a>

    <div class="container row fight">
    
            <div id="heroe" class="col s4">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo('img/'.$heroe->name.'.webp') ?>" alt=<?php echo $heroe->name ?>>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <h3 class="name"><?php echo $heroe -> name ?></h3>
                            <span class="activator"><i class="material-icons right">work</i></span>
                        </div>
                        
                        <h5>Hp: <span class="hp"><?php echo $heroe -> hp ?></span>/<?php echo $heroe -> hpMax ?></h5>
                        <h5>Mana: <span class="stamina"><?php echo $heroe -> stamina ?></span>/<?php echo $heroe -> staminaMax ?></h5>
                    </div>
                    <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Inventory<i class="material-icons right">close</i></span>
                    <ul>
                        <li><b>Sword:</b></li>
                        <li>name:  <span class="weaponName"><?php echo $heroe -> weapon -> name; ?></span></li>
                        <li>damage:  <span class="damage"><?php echo $heroe -> weapon -> damage; ?></span></li>
                    </ul>
                    <ul>
                        <li><b>Shield:</b></li>
                        <li>name:  <span class="shieldName"><?php echo $heroe -> shield -> name; ?></span></li>
                        <li>defense:  <span class="defense"><?php echo $heroe -> shield -> percentDefense; ?>%</span></li>
                    </ul>
                    <br>
                    <br>
                    <hr>
                    <div class="row">
                        <?php foreach ($heroe->inventory as $key => $value) { ?>
                            <div class="col s3 fight-heroe-item">
                                <?php switch(key($value)) { 
                                    case 'weapon': 
                                        $weapon = $GLOBALS[strtolower($value["weapon"])]; ?>
                                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($weapon->name) ?><br>DAMAGE: <?php echo $weapon->damage ?>">
                                        <img src="img/RPG_icons/<?php echo $weapon->name ?>.png" name="<?php echo $weapon->name ?>" data-type="weapon">
                                    </a>
                                <?php break; 
                                    case 'shield': 
                                        $shield = $GLOBALS[strtolower($value["shield"])]; ?>
                                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($shield->name) ?><br>DEFENSE: <?php echo $shield->percentDefense ?>%">
                                        <img src="img/RPG_icons/<?php echo $shield->name ?>.png" name="<?php echo $shield->name ?>" data-type="shield">
                                    </a>
                                <?php break; 
                                    case 'food': 
                                        $food = $GLOBALS[strtolower($value["food"])]; ?>
                                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($food->name) ?><br>MANA: +<?php echo $food->stamina ?>">
                                        <img src="img/RPG_icons/<?php echo $food->name ?>.png" name="<?php echo $food->name ?>" data-type="food">
                                    </a>
                                <?php break; ?>
                                <?php }  ?>    
                            </div>
                        <?php }  ?>
                        </div>
                    </div>
                    
                </div>
                <a style="margin-bottom:1%" class="button attack">Attack</a>
                <a style="margin-bottom:1%" class="button sleep">Sleep</a> 
                <a style="margin-bottom:1%" class="button eat">Eat</a> 
                <a style="margin-bottom:1%" class="button run">Run away</a>                             

                <div style="display: flex; justify-content: space-beetween">
                    <a style="width: 24%" data-move="nord" class="button move"><i class="material-icons small">expand_less</i></a>
                    <a style="width: 24%" data-move="sud" class="button move"><i class="material-icons small">expand_more</i></a>
                    <a style="width: 24%" data-move="ouest" class="button move"><i class="material-icons small">chevron_left</i></a>
                    <a style="width: 24%" data-move="est" class="button move"><i class="material-icons small">chevron_right</i></a>
                </div>                                        
            </div>


             <div id="monster" class="col s4">
                <div class="card">
                    <div class="card-image">
                    <img src="<?php echo('img/'.$monster->name.'.webp') ?>" alt=<?php echo $monster->name ?>>
                    </div>
                    <div class="card-content">
                    <div class="row">
                            <h3 class="name"><?php echo $monster -> name ?></h3>
                            <span class="activator"><i class="material-icons right">work</i></span>
                        </div>
                        <h5>Hp: <span class="hp"><?php echo $monster -> hp ?></span>/<?php echo $monster -> hpMax ?></h5>
                        <h5>Mana: <span class="stamina"><?php echo $monster -> stamina ?></span>/<?php echo $monster -> staminaMax ?></h5>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Inventory<i class="material-icons right">close</i></span>
                        
                        <ul>
                            <li><b>Sword:</b></li>
                            <li>name:  <span class="weaponName"><?php echo $monster -> weapon -> name; ?></span></li>
                            <li>damage:  <span class="damage"><?php echo $monster -> weapon -> damage; ?></span></li>
                        </ul>
                        <ul>
                            <li><b>Shield:</b></li>
                            <li>name:  <span class="shieldName"><?php echo $monster -> shield -> name; ?></span></li>
                            <li>defense:  <span class="percentDefense"><?php echo $monster -> shield -> percentDefense; ?>%</span></li>
                        </ul>
                        <br>
                        <br>
                        <hr>

                        <div class="row">
                        <?php foreach ($monster->inventory as $key => $value) { ?>
                            <div class="col s3 fight-monster-item">
                                <?php switch(key($value)) { 
                                    case 'weapon': 
                                        $weapon = $GLOBALS[strtolower($value["weapon"])]; ?>
                                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($weapon->name) ?><br>DAMAGE: <?php echo $weapon->damage ?>">
                                        <img src="img/RPG_icons/<?php echo $weapon->name ?>.png" name="<?php echo $weapon->name ?>" data-type="weapon">
                                    </a>
                                <?php break; 
                                    case 'shield': 
                                        $shield = $GLOBALS[strtolower($value["shield"])]; ?>
                                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($shield->name) ?><br>DEFENSE: <?php echo $shield->percentDefense ?>%">
                                        <img src="img/RPG_icons/<?php echo $shield->name ?>.png" name="<?php echo $shield->name ?>" data-type="shield">
                                    </a>
                                <?php break; 
                                    case 'food': 
                                        $food = $GLOBALS[strtolower($value["food"])]; ?>
                                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($food->name) ?><br>MANA: +<?php echo $food->stamina ?>">
                                        <img src="img/RPG_icons/<?php echo $food->name ?>.png" name="<?php echo $food->name ?>" data-type="food">
                                    </a>
                                <?php break; ?>
                                <?php } ?>    
                            </div>
                        <?php }  ?>
                        </div>
                    </div>
                        
                </div>
                <a style="margin-bottom:1%" class="button attack">Attack</a>
                <a style="margin-bottom:1%" class="button sleep">Sleep</a> 
                <a style="margin-bottom:1%" class="button eat">Eat</a> 
                <a style="margin-bottom:1%" class="button run">Run away</a>                             

                <div style="display: flex; justify-content: space-beetween">
                    <a style="width: 24%" data-move="nord" class="button move"><i class="material-icons small">expand_less</i></a>
                    <a style="width: 24%" data-move="sud" class="button move"><i class="material-icons small">expand_more</i></a>
                    <a style="width: 24%" data-move="ouest" class="button move"><i class="material-icons small">chevron_left</i></a>
                    <a style="width: 24%" data-move="est" class="button move"><i class="material-icons small">chevron_right</i></a>
                </div>   
            </div>


    <table id="battleground">
        <tr>
            <td><div class="content">9</div></td>
            <td data-posX="0" data-posY="9"><div class="content"></div></td>
            <td data-posX="1" data-posY="9"><div class="content"></div></td>
            <td data-posX="2" data-posY="9"><div class="content"></div></td>
            <td data-posX="3" data-posY="9"><div class="content"></div></td>
            <td data-posX="4" data-posY="9"><div class="content"></div></td>
            <td data-posX="5" data-posY="9"><div class="content"></div></td>
            <td data-posX="6" data-posY="9"><div class="content"></div></td>
            <td data-posX="7" data-posY="9"><div class="content"></div></td>
            <td data-posX="8" data-posY="9"><div class="content"></div></td>
            <td data-posX="9" data-posY="9"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">8</div></td>
            <td data-posX="0" data-posY="8"><div class="content"></div></td>
            <td data-posX="1" data-posY="8"><div class="content"></div></td>
            <td data-posX="2" data-posY="8"><div class="content"></div></td>
            <td data-posX="3" data-posY="8"><div class="content"></div></td>
            <td data-posX="4" data-posY="8"><div class="content"></div></td>
            <td data-posX="5" data-posY="8"><div class="content"></div></td>
            <td data-posX="6" data-posY="8"><div class="content"></div></td>
            <td data-posX="7" data-posY="8"><div class="content"></div></td>
            <td data-posX="8" data-posY="8"><div class="content"></div></td>
            <td data-posX="9" data-posY="8"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">7</div></td>
            <td data-posX="0" data-posY="7"><div class="content"></div></td>
            <td data-posX="1" data-posY="7"><div class="content"></div></td>
            <td data-posX="2" data-posY="7"><div class="content"></div></td>
            <td data-posX="3" data-posY="7"><div class="content"></div></td>
            <td data-posX="4" data-posY="7"><div class="content"></div></td>
            <td data-posX="5" data-posY="7"><div class="content"></div></td>
            <td data-posX="6" data-posY="7"><div class="content"></div></td>
            <td data-posX="7" data-posY="7"><div class="content"></div></td>
            <td data-posX="8" data-posY="7"><div class="content"></div></td>
            <td data-posX="9" data-posY="7"><div class="content"></div></td>
        </tr>
        <td><div class="content">6</div></td>
            <td data-posX="0" data-posY="6"><div class="content"></div></td>
            <td data-posX="1" data-posY="6"><div class="content"></div></td>
            <td data-posX="2" data-posY="6"><div class="content"></div></td>
            <td data-posX="3" data-posY="6"><div class="content"></div></td>
            <td data-posX="4" data-posY="6"><div class="content"></div></td>
            <td data-posX="5" data-posY="6"><div class="content"></div></td>
            <td data-posX="6" data-posY="6"><div class="content"></div></td>
            <td data-posX="7" data-posY="6"><div class="content"></div></td>
            <td data-posX="8" data-posY="6"><div class="content"></div></td>
            <td data-posX="9" data-posY="6"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">5</div></td>
            <td data-posX="0" data-posY="5"><div class="content"></div></td>
            <td data-posX="1" data-posY="5"><div class="content"></div></td>
            <td data-posX="2" data-posY="5"><div class="content"></div></td>
            <td data-posX="3" data-posY="5"><div class="content"></div></td>
            <td data-posX="4" data-posY="5"><div class="content"></div></td>
            <td data-posX="5" data-posY="5"><div class="content"></div></td>
            <td data-posX="6" data-posY="5"><div class="content"></div></td>
            <td data-posX="7" data-posY="5"><div class="content"></div></td>
            <td data-posX="8" data-posY="5"><div class="content"></div></td>
            <td data-posX="9" data-posY="5"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">4</div></td>
            <td data-posX="0" data-posY="4"><div class="content"></div></td>
            <td data-posX="1" data-posY="4"><div class="content"></div></td>
            <td data-posX="2" data-posY="4"><div class="content"></div></td>
            <td data-posX="3" data-posY="4"><div class="content"></div></td>
            <td data-posX="4" data-posY="4"><div class="content"></div></td>
            <td data-posX="5" data-posY="4"><div class="content"></div></td>
            <td data-posX="6" data-posY="4"><div class="content"></div></td>
            <td data-posX="7" data-posY="4"><div class="content"></div></td>
            <td data-posX="8" data-posY="4"><div class="content"></div></td>
            <td data-posX="9" data-posY="4"><div class="content"></div></td>
        </tr>
        <td><div class="content">3</div></td>
            <td data-posX="0" data-posY="3"><div class="content"></div></td>
            <td data-posX="1" data-posY="3"><div class="content"></div></td>
            <td data-posX="2" data-posY="3"><div class="content"></div></td>
            <td data-posX="3" data-posY="3"><div class="content"></div></td>
            <td data-posX="4" data-posY="3"><div class="content"></div></td>
            <td data-posX="5" data-posY="3"><div class="content"></div></td>
            <td data-posX="6" data-posY="3"><div class="content"></div></td>
            <td data-posX="7" data-posY="3"><div class="content"></div></td>
            <td data-posX="8" data-posY="3"><div class="content"></div></td>
            <td data-posX="9" data-posY="3"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">2</div></td>
            <td data-posX="0" data-posY="2"><div class="content"></div></td>
            <td data-posX="1" data-posY="2"><div class="content"></div></td>
            <td data-posX="2" data-posY="2"><div class="content"></div></td>
            <td data-posX="3" data-posY="2"><div class="content"></div></td>
            <td data-posX="4" data-posY="2"><div class="content"></div></td>
            <td data-posX="5" data-posY="2"><div class="content"></div></td>
            <td data-posX="6" data-posY="2"><div class="content"></div></td>
            <td data-posX="7" data-posY="2"><div class="content"></div></td>
            <td data-posX="8" data-posY="2"><div class="content"></div></td>
            <td data-posX="9" data-posY="2"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">1</div></td>
            <td data-posX="0" data-posY="1"><div class="content"></div></td>
            <td data-posX="1" data-posY="1"><div class="content"></div></td>
            <td data-posX="2" data-posY="1"><div class="content"></div></td>
            <td data-posX="3" data-posY="1"><div class="content"></div></td>
            <td data-posX="4" data-posY="1"><div class="content"></div></td>
            <td data-posX="5" data-posY="1"><div class="content"></div></td>
            <td data-posX="6" data-posY="1"><div class="content"></div></td>
            <td data-posX="7" data-posY="1"><div class="content"></div></td>
            <td data-posX="8" data-posY="1"><div class="content"></div></td>
            <td data-posX="9" data-posY="1"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content">0</div></td>
            <td data-posX="0" data-posY="0"><div class="content"></div></td>
            <td data-posX="1" data-posY="0"><div class="content"></div></td>
            <td data-posX="2" data-posY="0"><div class="content"></div></td>
            <td data-posX="3" data-posY="0"><div class="content"></div></td>
            <td data-posX="4" data-posY="0"><div class="content"></div></td>
            <td data-posX="5" data-posY="0"><div class="content"></div></td>
            <td data-posX="6" data-posY="0"><div class="content"></div></td>
            <td data-posX="7" data-posY="0"><div class="content"></div></td>
            <td data-posX="8" data-posY="0"><div class="content"></div></td>
            <td data-posX="9" data-posY="0"><div class="content"></div></td>
        </tr>
        <tr>
            <td><div class="content"></div></td>
            <td><div class="content">0</div></td>
            <td><div class="content">1</div></td>
            <td><div class="content">2</div></td>
            <td><div class="content">3</div></td>
            <td><div class="content">4</div></td>
            <td><div class="content">5</div></td>
            <td><div class="content">6</div></td>
            <td><div class="content">7</div></td>
            <td><div class="content">8</div></td>
            <td><div class="content">9</div></td>
        </tr>
    </table>
            
    </div>
    
            <div id="modal-cemetery" class="modal">
                <div class="modal-content">
                    <h4>Cemetery</h4>
                    <div id="cemetery">
                        
                    </div>
                </div>
                    <div class="modal-footer">
                    <a href="#!" class="modal-close button">close</a>
                </div>
            </div>

</body>

<script src="js/main.js"></script>
</html>