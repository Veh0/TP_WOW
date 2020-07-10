<?php 

        include_once('main.php'); 
        
        fight($_POST["heroe"], json_decode($_POST["heroeItems"], true)); 
        fight($_POST["monster"], json_decode($_POST["monsterItems"], true));

        $heroe = $GLOBALS[strtolower($_POST["heroe"])];
        $monster = $GLOBALS[strtolower($_POST["monster"])];
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
    
            <div id="heroe" class="col s3">
                <div class="card">
                    <div class="card-image">
                        <img src="<?php echo('img/'.$heroe->name.'.webp') ?>" alt=<?php echo $heroe->name ?>>
                    </div>
                    <div class="card-content">
                        <h3 class="name"><?php echo $heroe -> name ?></h3>
                        <h4>Hp: <span class="hp"><?php echo $heroe -> hp ?></span></h4>
                        <h4>Mana: <span class="stamina"><?php echo $heroe -> stamina ?></span></h4>
                    <ul>
                        <li><b>Sword:</b></li>
                        <li>name:  <?php echo $heroe -> weapon -> name; ?></li>
                        <li>damage:  <span class="damage"><?php echo $heroe -> weapon -> damage; ?></span></li>
                        <li>height:  <?php echo $heroe -> weapon -> height; ?>cm</li>
                        <li>weight:  <?php echo $heroe -> weapon -> weight; ?>g</li>
                    </ul>
                    </div>
                    <div class="card-action">
                    <div class="row">
                        <?php foreach ($heroe->inventory as $key => $value) { ?>
                            <div class="col s3 select-heroe-item">
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
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>


            <div id="monster" class="col s3">
                <div class="card">
                    <div class="card-image">
                    <img src="<?php echo('img/'.$monster->name.'.webp') ?>" alt=<?php echo $monster->name ?>>
                    </div>
                    <div class="card-content">
                        <h3 class="name"><?php echo $monster -> name ?></h3>
                        <h4>Hp: <span class="hp"><?php echo $monster -> hp ?></span></h4>
                        <h4>Mana: <span class="stamina"><?php echo $monster -> stamina ?></span></h4>
                    <ul>
                        <li><b>Sword:</b></li>
                        <li>name:  <?php echo $monster -> weapon -> name; ?></li>
                        <li>damage:  <span class="damage"><?php echo $monster -> weapon -> damage; ?></span></li>
                        <li>height:  <?php echo $monster -> weapon -> height; ?>cm</li>
                        <li>weight:  <?php echo $monster -> weapon -> weight; ?>g</li>
                    </ul>
                    </div>
                    <div class="card-action">
                        <div class="row">
                        <?php foreach ($monster->inventory as $key => $value) { ?>
                            <div class="col s3 select-monster-item">
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
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            
    </div>
    <a class="button" id="playBtn">Play</a>
    
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