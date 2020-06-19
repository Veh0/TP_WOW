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
                <div class="unselect select-heroe col s8">
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

        <h2>MONSTERS</h2>
        <hr>
        <div class="row" id="monsters">
            <?php foreach ($monsters as $monster) { ?>
                <div class="unselect select-monster col s8">
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

        <a href="fight.php" id="fight" class="button">Fight !</a>
    </div>

</body>

<script src="js/main.js"></script>
</html>