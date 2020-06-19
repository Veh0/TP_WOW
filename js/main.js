// VARIABLES

var heroeHp = $("#heroe .hp");
var heroeButton = $("#heroe .button");
var heroeDamage = $("#heroe .damage");

var monsterHp = $("#monster .hp");
var monsterButton = $("#monster .button");
var monsterDamage = $("#monster .damage");

var player;
var firstTour = 1;


/* heroe = 1  && monster = 0 */

function chooseFirstPlayer() {
    let firstPlayer = Math.floor(Math.random() * 2);
    player = firstPlayer;
    firstTour = 0;
    if (player == 1) {
        monsterButton.addClass("disable")
    } else {
        heroeButton.addClass("disable")
    }
}

function play() {
    if (player == 1) {
        monsterButton.removeClass("disable")
        heroeButton.addClass("disable")
        player = 0;
        /* function php */
        getDamage(player, monsterHp.text(),heroeDamage.text());
        if (ripost()) {
            getDamage(1, heroeHp.text(), monsterDamage.text()/2)
            $("#heroe img").addClass('blink');
            setTimeout('$("#heroe img").removeClass("blink")', 1000);
        }
        $("#monster img").addClass('blink');
        setTimeout('$("#monster img").removeClass("blink")', 1000);
        
    } else {
        heroeButton.removeClass("disable")
        monsterButton.addClass("disable")
        player = 1;
        /* function php */
        getDamage(player, heroeHp.text(),monsterDamage.text());
        if (ripost()) {
            getDamage(0, monsterHp.text(), heroeDamage.text()/2)
            $("#monster img").addClass('blink');
            setTimeout('$("#monster img").removeClass("blink")', 1000);
        }
        $("#heroe img").addClass('blink');
        setTimeout('$("#heroe img").removeClass("blink")', 1000);       
    }

}

function ripost() {
    let ripost = Math.floor(Math.random() * 4);
    if (ripost == 1) {
        return true;
    } else {
        return false
    }
}

function playerDeath(playerCharacter) {
    $.ajax({
        method: 'post',
        url: 'main.php',
        data: {
            'action': 'ajaxPlayerDeath',
            'player': playerCharacter
        }
    }).done(function(result) {
        $('#cemetery').append("<img class='lose' src='img/"+result+".webp' alt='"+result+"'>")
    })
}

function getDamage(playerCharacter, hp, damage) {
    $.ajax({
        method: 'post',
        url: 'main.php',
        data: {
            'action': 'ajaxGetDamage',
            'player': playerCharacter,
            'hp' : hp,
            'damage': damage
        }
    }).done(function(result) {
        if (playerCharacter == 1) {
            heroeHp.text(result)
            if (result <= 0) {
                $("#heroe img").addClass("lose")
                heroeButton.addClass("disable")
                monsterButton.addClass("disable")
                playerDeath(playerCharacter)
                alert($("#monster .name").text()+" Win !")
            }
        } else {
            monsterHp.text(result)
            if (result <= 0) {
                $("#monster img").addClass("lose")
                heroeButton.addClass("disable")
                monsterButton.addClass("disable")
                playerDeath(playerCharacter)
                alert($("#heroe .name").text()+" Win !")
            }
        }
    })
}

chooseFirstPlayer()

monsterButton.click(function(e) {
    e.preventDefault();
    play()
})

heroeButton.click(function(e) {
    e.preventDefault();
    play()
})

// INIT
$(document).ready(function(){
    $('.modal').modal();
  });