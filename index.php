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
    <?php include_once('main.php'); ?>

    <div class="container">

        <h2>HEROES</h2>
        <hr>
        <div class="row" id="heroes">
            <?php foreach ($heroes as $heroe) { ?>
                <div class="unselect select-heroe col s8 tooltipped" data-position="top" data-tooltip="PV: <?php echo $heroe->hp ?><br>MANA: <?php echo $heroe->stamina ?>">
                    <div class="card">
                        <div class="card-image">
                            <img src="<?php echo('img/'.$heroe->name.'.webp') ?>" alt=<?php echo $heroe->name ?>>
                        </div>
                        <div class="card-content">
                            <h3 style="text-align: center" class="name"><?php echo $heroe->name ?></h3>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <h3>Choose Heroe's items:</h3>
        <br>
        <div class="row">
            <?php foreach ($weapons as $weapon) { ?>
                <div class="col s1 unselect select-heroe-item">
                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($weapon->name) ?><br>DAMAGE: <?php echo $weapon->damage ?>">
                        <img src="img/RPG_icons/<?php echo $weapon->name ?>.png" name="<?php echo $weapon->name ?>" data-type="weapon">
                    </a>
                </div>
            <?php } ?>    
            <?php foreach ($shields as $shield) { ?>
                <div class="col s1 unselect select-heroe-item">
                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($shield->name) ?><br>DEFENSE: <?php echo $shield->percentDefense ?>%">
                        <img src="img/RPG_icons/<?php echo $shield->name ?>.png" name="<?php echo $shield->name ?>" data-type="shield">
                    </a>
                </div>
            <?php } ?>   
            <?php foreach ($foods as $food) { ?>
                <div class="col s1 unselect select-heroe-item">
                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($food->name) ?><br>MANA: +<?php echo $food->stamina ?>">
                        <img src="img/RPG_icons/<?php echo $food->name ?>.png" name="<?php echo $food->name ?>" data-type="food">
                    </a>
                </div>
            <?php } ?>               
        </div>
        <br>
        <hr>

        <h2>MONSTERS</h2>
        <hr>
        <div class="row" id="monsters">
            <?php foreach ($monsters as $monster) { ?>
                <div class="unselect select-monster col s8 tooltipped" data-position="top" data-tooltip="PV: <?php echo $monster->hp ?><br>MANA: <?php echo $monster->stamina ?>">
                    <div class="card">
                        <div class="card-image">
                            <img src="<?php echo('img/'.$monster->name.'.webp') ?>" alt=<?php echo $monster->name ?>>
                        </div>
                        <div class="card-content">
                            <h3 style="text-align: center" class="name"><?php echo $monster->name ?></h3>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <h3>Choose Monster's items:</h3>
        <br>
        <div class="row">
            <?php foreach ($weapons as $weapon) { ?>
                <div class="col s1 unselect select-monster-item">
                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($weapon->name) ?><br>DAMAGE: <?php echo $weapon->damage ?>">
                        <img src="img/RPG_icons/<?php echo $weapon->name ?>.png" name="<?php echo $weapon->name ?>" data-type="weapon">
                    </a>
                </div>
            <?php } ?>    
            <?php foreach ($shields as $shield) { ?>
                <div class="col s1 unselect select-monster-item">
                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($shield->name) ?><br>DEFENSE: <?php echo $shield->percentDefense ?>%">
                        <img src="img/RPG_icons/<?php echo $shield->name ?>.png" name="<?php echo $shield->name ?>" data-type="shield">
                    </a>
                </div>
            <?php } ?>   
            <?php foreach ($foods as $food) { ?>
                <div class="col s1 unselect select-monster-item">
                    <a class="tooltipped" data-position="bottom" data-tooltip="<?php echo strtoUpper($food->name) ?><br>MANA: +<?php echo $food->stamina ?>">
                        <img src="img/RPG_icons/<?php echo $food->name ?>.png" name="<?php echo $food->name ?>" data-type="food">
                    </a>
                </div>
            <?php } ?>               
        </div>
        <br>
        <form id="fight" action="fight.php" method="post">
            <input type="hidden" name="heroe">
            <input type="hidden" name="heroeHp">
            <input type="hidden" name="heroeStamina">
            <input type="hidden" name="heroeItems">
            <input type="hidden" name="monster">
            <input type="hidden" name="monsterHp">
            <input type="hidden" name="monsterStamina">
            <input type="hidden" name="monsterItems">
            <button class="button">Fight !</a>
        </form>
    </div>

</body>

<script src="js/main.js"></script>
</html>