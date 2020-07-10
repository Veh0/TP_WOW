// VARIABLES

var heroeHp = $("#heroe .hp");
var heroeStamina = $("#heroe .stamina");
var heroeButton = $("#heroe .button");
var heroeDamage = $("#heroe .damage");
var heroeName = $("#heroe .name").text();

var actifHeroe;
var heroeItems = [];

var monsterHp = $("#monster .hp");
var monsterStamina = $("#monster .stamina");
var monsterButton = $("#monster .button");
var monsterDamage = $("#monster .damage");
var monsterName = $("#monster .name").text();


var actifMonster;
var monsterItems = [];

/* heroe = 1  && monster = 0 */

function chooseFirstPlayer() {
    let firstPlayer = Math.floor(Math.random() * 2);
    return firstPlayer;
}

function hasWeapon(array) {
    
    for (let index = 0; index < array.length; index++) {
        const element = array[index];
        if (typeof element.weapon !== "undefined") {
            return true;
        }
    }

}

function play() {

    let firstPlayer = chooseFirstPlayer();

    /*

    1 = J1 attaque J2, J2 se défend contre J1
                        OU
        J2 attaque J1, J1 se défend contre J2 

    2 = J1 mange, J2 attaque J1 
                  OU
        J2 attaque J1, J1 mange 

    3 = J1 mange, J2 mange 

    */
   let action = Math.floor(Math.random() * 3) + 1;

    switch (action) {
        case 1:
            if (firstPlayer == 1) {
                if(parseFloat(heroeStamina.text()) > 0) { 
                    attack(heroeName, heroeStamina.text())
                    getDamage(monsterName, monsterHp.text(), heroeDamage.text(), monsterStamina.text(), true)
                } else {
                    M.toast({html: heroeName+' : Je n\'ai pas assez d\'énergie', displayLength: 2000})
                }
            } else {
                if(parseFloat(monsterStamina.text()) > 0) { 
                    attack(monsterName, monsterStamina.text())
                    getDamage(heroeName, heroeHp.text(), monsterDamage.text(), heroeStamina.text(), true)
                } else {
                    M.toast({html: monsterName+' : Je n\'ai pas assez d\'énergie', displayLength: 2000})
                }
            }
        break;
    
        case 2:
            if (firstPlayer == 1) {
                eat(heroeName, heroeStamina.text())
                M.toast({html: heroeName+' mange', displayLength: 2000})
                
                if(parseFloat(monsterStamina.text()) > 0) {
                    attack(monsterName, monsterStamina.text())
                    getDamage(heroeName, heroeHp.text(), monsterDamage.text(), heroeStamina.text(), false)
                    M.toast({html: monsterName+' inflige des dégats à '+heroeName, displayLength: 2000})
                } else {
                    M.toast({html: monsterName+' : Je n\'ai pas assez d\'énergie', displayLength: 2000})
                }
                
            } else {
                eat(monsterName, monsterStamina.text())
                M.toast({html: monsterName+' mange', displayLength: 2000})
                if(parseFloat(heroeStamina.text()) > 0) {
                    attack(heroeName, heroeStamina.text())
                    getDamage(monsterName, monsterHp.text(), monsterDamage.text(), monsterStamina.text(), false)
                    M.toast({html: heroeName+' inflige des dégats à '+monsterName, displayLength: 2000})
                } else {
                    M.toast({html: heroeName+' : Je n\'ai pas assez d\'énergie', displayLength: 2000})
                }
                
            }
        break;

        case 3:
            eat(heroeName, heroeStamina.text())
            eat(monsterName, monsterStamina.text())
            M.toast({html: heroeName+' et '+monsterName+' s\'assoient et mangent', displayLength: 700})
        break;
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

// ACTIONS COMBAT
function getDamage(playerCharacter, hp, damage, stamina, defense) {

    let playerItems = []
    if (playerCharacter == heroeName) {
        let select = document.querySelectorAll('.select-heroe-item img')
        select.forEach(element => {
            playerItems.push({ [element.dataset.type] : element.name})
        });
    } else {
        let select = document.querySelectorAll('.select-monster-item img')
        select.forEach(element => {
            playerItems.push({ [element.dataset.type] : element.name})
        });
    }

    var data = {
        'action': 'ajaxGetDamage',
        'player': playerCharacter,
        'playerItems': JSON.stringify(playerItems),
        'hp' : hp,
        'damage': damage,
        'stamina': stamina,
        'defense': defense
    }

    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function(result) {
        result = JSON.parse(result)
        if (playerCharacter == heroeName) {
            heroeHp.text(result["hp"])
            heroeStamina.text(result["stamina"])

            $("#heroe img").addClass('blink');
            setTimeout('$("#heroe img").removeClass("blink")', 1000)
            if (result["hp"] <= 0) {
                $("#heroe img").addClass("lose")
                heroeButton.addClass("disable")
                monsterButton.addClass("disable")
                playerDeath(playerCharacter)
                alert($("#monster .name").text()+" Win !")
            }
        } else {
            monsterHp.text(result["hp"])
            $("#monster img").addClass('blink');
            setTimeout('$("#monster img").removeClass("blink")', 1000)
            if (result["hp"] <= 0) {
                $("#monster img").addClass("lose")
                heroeButton.addClass("disable")
                monsterButton.addClass("disable")
                playerDeath(playerCharacter)
                alert($("#heroe .name").text()+" Win !")
            }
        }
    })
}

function attack(playerCharacter, stamina) {
    let playerItems = []
    if (playerCharacter == heroeName) {
        let select = document.querySelectorAll('.select-heroe-item img')
        select.forEach(element => {
            playerItems.push({ [element.dataset.type] : element.name})
        });
    } else {
        let select = document.querySelectorAll('.select-monster-item img')
        select.forEach(element => {
            playerItems.push({ [element.dataset.type] : element.name})
        });
    }

    var data = {
            'action': 'ajaxAttack',
            'player': playerCharacter,
            'playerItems': JSON.stringify(playerItems),
            'stamina' : stamina
        }

    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function (result) {
        if (playerCharacter == heroeName) {
            heroeStamina.text(result)
        } else {
            monsterStamina.text(result)
        }
    })
}

function eat(playerCharacter, stamina) {
    
    let playerItems = []
    if (playerCharacter == heroeName) {
        let select = document.querySelectorAll('.select-heroe-item img')
        select.forEach(element => {
            playerItems.push({ [element.dataset.type] : element.name})
        });
    } else {
        let select = document.querySelectorAll('.select-monster-item img')
        select.forEach(element => {
            playerItems.push({ [element.dataset.type] : element.name})
        });
    }

    var data = {
            'action': 'ajaxEat',
            'player': playerCharacter,
            'playerItems': JSON.stringify(playerItems),
            'stamina': stamina
        }
    
    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function (result) {
        if (playerCharacter == heroeName) {
            heroeStamina.text(result)
        } else {
            monsterStamina.text(result)
        }
    })
}


// chooseFirstPlayer()

monsterButton.click(function(e) {
    e.preventDefault();
    play()
})

heroeButton.click(function(e) {
    e.preventDefault();
    play()
})

$(".select-heroe").click(function(e) {
    e.preventDefault();
    $('.select-heroe').addClass("unselect")
    $(this).removeClass("unselect")
    heroeName = this.querySelector(".name")
    actifHeroe = heroeName.textContent
})

$(".select-heroe-item").click(function(e) {
    e.preventDefault();

    let item = this.querySelector("img")
    let itemName = item.name
    let itemType = item.dataset.type

    var find = 0
    
    for (let index = 0; index < heroeItems.length; index++) {
        let element = heroeItems[index];
        if(Object.values(element) == itemName) find = 1
    }

    
    if (find == 0) {
        if (heroeItems.length < 4) {
            $(this).removeClass("unselect")
            heroeItems.push({ [itemType]: itemName})
        } else {
            M.toast({html: 'Inventory full', displayLength: 700})
        }
        
    } else {
        $(this).addClass("unselect")
        
        const index = heroeItems.findIndex(element => element[itemType] == itemName);
        if (index > -1) {
            heroeItems.splice(index, 1);
        }
    }
})


$(".select-monster").click(function(e) {
    e.preventDefault();
    $('.select-monster').addClass("unselect")
    $(this).removeClass("unselect")
    monsterName = this.querySelector(".name")
    actifMonster = monsterName.textContent
})

$(".select-monster-item").click(function(e) {
    e.preventDefault();
    let item = this.querySelector("img")
    let itemName = item.name
    let itemType = item.dataset.type

    var find = 0
    
    for (let index = 0; index < monsterItems.length; index++) {
        let element = monsterItems[index];
        if(Object.values(element) == itemName) find = 1
    }

    if (find == 0) {
        if (monsterItems.length < 4) {
            $(this).removeClass("unselect")
            monsterItems.push({ [itemType]: itemName})
        } else {
            M.toast({html: 'Inventory full', displayLength: 700})
        }
        
    } else {
        $(this).addClass("unselect")
        const index = monsterItems.findIndex(element => element[itemType] == itemName);
        if (index > -1) {
            monsterItems.splice(index, 1);
        }
    }
})


$("#fight button").click(function(e) {
    e.preventDefault();
    if (typeof actifHeroe === "undefined") {
        M.toast({html: 'Select a heroe', displayLength: 1000})
    } else if (typeof actifMonster === "undefined") {
        M.toast({html: 'Select a monster', displayLength: 1000})
    } else if (!hasWeapon(heroeItems)) {
        M.toast({html: "Your Heroe doesn't have weapon", displayLength: 1000})
    } else if (!hasWeapon(monsterItems)) {
        M.toast({html: "Your Monster doesn't have weapon", displayLength: 1000})
    } else {
        $("#fight input[name='heroe']").val(actifHeroe)
        $("#fight input[name='heroeHp']").val(heroeHp.text())
        $("#fight input[name='heroeStamina']").val(heroeStamina.text())
        $("#fight input[name='heroeItems']").val(JSON.stringify(heroeItems))
        $("#fight input[name='monster']").val(actifMonster)
        $("#fight input[name='monsterHp']").val(monsterHp.text())
        $("#fight input[name='monsterStamina']").val(monsterStamina.text())
        $("#fight input[name='monsterItems']").val(JSON.stringify(monsterItems))
        $("#fight").submit()
    }
    
})

$("#playBtn").click(function(e) {
    e.preventDefault();
    play()
})

// INIT
$(document).ready(function(){
    $('.modal').modal();
});

$(document).ready(function(){
    $('.tooltipped').tooltip();
});



/* function playOld(){
    if (player == 1) {
        monsterButton.removeClass("disable")
        heroeButton.addClass("disable")
        player = 0;
        // function php 
        getDamage($("#monster .name").text().toLowerCase(), monsterHp.text(),heroeDamage.text());
        if (ripost()) {
            getDamage($("#heroe .name").text().toLowerCase(), heroeHp.text(), monsterDamage.text()/2)
            $("#heroe img").addClass('blink');
            setTimeout('$("#heroe img").removeClass("blink")', 1000);
        }  
        $("#monster img").addClass('blink');
        setTimeout('$("#monster img").removeClass("blink")', 1000);
        
    } else {
        heroeButton.removeClass("disable")
        monsterButton.addClass("disable")
        player = 1;
        // function php 
        getDamage($("#heroe .name").text().toLowerCase(), heroeHp.text(),monsterDamage.text());
        /* if (ripost()) {
            getDamage($("#monster .name").text().toLowerCase(), monsterHp.text(), heroeDamage.text()/2)
            $("#monster img").addClass('blink');
            setTimeout('$("#monster img").removeClass("blink")', 1000);
        } 
        $("#heroe img").addClass('blink');
        setTimeout('$("#heroe img").removeClass("blink")', 1000);       
    }
} */