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

    <a class="waves-effect waves-light btn grey darken-3 modal-trigger" href="#modal-cemetery">Cemetery</a>

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

    <div id="container" class="row">
    
            <div id="heroe" class="col s3">
                <div class="card">
                    <div class="card-image">
                        <img src="img/Uther.webp" alt="Uther">
                    </div>
                    <div class="card-content">
                        <h3 class="name"><?php echo $heroe -> name ?></h3>
                        <h4 class="hp"><?php echo $heroe -> hp ?></h4>
                    
                    <ul>
                        <li><b>Sword:</b></li>
                        <li>name:  <?php echo $heroe -> weapon -> name; ?></li>
                        <li>damage:  <span class="damage"><?php echo $heroe -> weapon -> damage; ?></span></li>
                        <li>height:  <?php echo $heroe -> weapon -> height; ?>cm</li>
                        <li>weight:  <?php echo $heroe -> weapon -> weight; ?>g</li>
                    </ul>
                    </div>
                        <div class="card-action">
                        <a class="button" href="">Attack !</a>
                    </div>
                </div>
            </div>


            <div id="monster" class="col s3">
                <div class="card">
                    <div class="card-image">
                        <img src="img/Thrall.webp" alt="Thrall">
                    </div>
                    <div class="card-content">
                        <h3 class="name"><?php echo $monster -> name ?></h3>
                        <h4 class="hp"><?php echo $monster -> hp ?></h4>
                        
                    <ul>
                        <li><b>Sword:</b></li>
                        <li>name:  <?php echo $monster -> weapon -> name; ?></li>
                        <li>damage:  <span class="damage"><?php echo $monster -> weapon -> damage; ?></span></li>
                        <li>height:  <?php echo $monster -> weapon -> height; ?>cm</li>
                        <li>weight:  <?php echo $monster -> weapon -> weight; ?>g</li>
                    </ul>
                    </div>
                        <div class="card-action">
                        <a class="button" href="">Attack !</a>
                    </div>
                </div>
            </div>


    </div>

</body>

<script src="js/main.js"></script>
</html>