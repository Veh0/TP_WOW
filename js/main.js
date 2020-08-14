// VARIABLES
var heroeHp = $("#heroe .hp");
var heroeStamina = $("#heroe .stamina");
var heroeDamage = $("#heroe .damage");
var heroeName = $("#heroe .name").text();
var heroeCoord = []

var actifHeroe;
var heroeItems = [];

var monsterHp = $("#monster .hp");
var monsterStamina = $("#monster .stamina");
var monsterDamage = $("#monster .damage");
var monsterName = $("#monster .name").text();
var monsterCoord = []


var actifMonster;
var monsterItems = [];

var bg = $('#battleground td');
var player;

/* heroe = 1  && monster = 0 */

function takePlace() {
    var heroeX = Math.floor(Math.random() * 10)
    var heroeY = Math.floor(Math.random() * 10)
    heroeCoord = [heroeX, heroeY]

    var monsterX = Math.floor(Math.random() * 10)
    var monsterY = Math.floor(Math.random() * 10)
    monsterCoord = [monsterX, monsterY]

    for (let index = 0; index < bg.length; index++) {
        let element = bg[index]
        //console.log(element.dataset)
        if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == heroeX) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == heroeY)) {
            img = document.createElement("img")
            img.src = "img/"+heroeName+".webp"
            img.style = "width: 100%; position: absolute"
            element.appendChild(img)
        }

        if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == monsterX) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == monsterY)) {
            img = document.createElement("img")
            img.src = "img/"+monsterName+".webp"
            img.style = "width: 100%; position: absolute"
            element.appendChild(img)
        }
    };
}

// FONCTION DEROULEMENT DE PARTIE
function chooseFirstPlayer() {
    let firstPlayer = Math.floor(Math.random() * 2);

    if (firstPlayer == 0) {
        $('#monster .button').addClass('disable')
    } else {
        $('#heroe .button').addClass('disable')
    }

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

function changePlayer() {
    if (player == 0) {
        player = 1
        $('#monster .button').removeClass('disable')
        $('#heroe .button').addClass('disable')
    } else {
        player = 0
        $('#heroe .button').removeClass('disable')
        $('#monster .button').addClass('disable')
    }
}

// PLAYERS ACTIONS
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
function getDamage(playerCharacter) {

    let playerItems = getItems(playerCharacter)

    if (playerCharacter == heroeName) {
        hp = heroeHp.text()
        stamina = heroeStamina.text()
        damage = monsterDamage.text()
    } else {
        hp = monsterHp.text()
        stamina = monsterStamina.text()
        damage = heroeDamage.text()
    }

    var data = {
        'action': 'ajaxGetDamage',
        'player': playerCharacter,
        'playerItems': JSON.stringify(playerItems),
        'hp' : hp,
        'damage': damage,
        'stamina': stamina,
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
                $("#monster .button").addClass("disable")
                $("#heroe .button").addClass("disable")
                playerDeath(playerCharacter)
                alert(monsterName + " Win !")
            }
        } else {
            monsterHp.text(result["hp"])
            monsterStamina.text(result["stamina"])
            $("#monster img").addClass('blink');
            setTimeout('$("#monster img").removeClass("blink")', 1000)
            if (result["hp"] <= 0) {
                $("#monster img").addClass("lose")
                $("#heroe .button").addClass("disable")
                $("#monster .button").addClass("disable")
                playerDeath(playerCharacter)
                alert(heroeName + " Win !")
            }
        }

        if (result["error"] == 1) {
            M.toast({html: playerCharacter + " is too exhaustive to protect himself", displayLength: 2000})
        } else {
            M.toast({html: playerCharacter + " hold his shield to protect himself", displayLength: 2000})
        }
    })
}

function attack(playerCharacter) {
    let playerItems = getItems(playerCharacter)

    if (playerCharacter == heroeName) {
        stamina = heroeStamina.text()
        coord = heroeCoord
        enemyCoord = monsterCoord
        enemy = monsterName
    } else {
        stamina = monsterStamina.text()
        coord = monsterCoord
        enemyCoord = heroeCoord
        enemy = heroeName
    }

    var data = {
            'action': 'ajaxAttack',
            'player': playerCharacter,
            'playerItems': JSON.stringify(playerItems),
            'coord': coord,
            'enemyCoord': enemyCoord,
            'stamina' : stamina
        }

    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function (result) {
        result = JSON.parse(result)
        console.log(result)
        var error = result["error"]
        var stamina = result["stamina"]
        if (playerCharacter == heroeName) {
            heroeStamina.text(stamina)
        } else {
            monsterStamina.text(stamina)
        } 

        if (error == 0) {
            getDamage(enemy)
            M.toast({html: playerCharacter + " attack his ennemy", displayLength: 2000})
            changePlayer()
        } else if(error == 1) {
            M.toast({html: playerCharacter + " is too far to attack", displayLength: 2000})
        } else if(error == 2) {
            M.toast({html: playerCharacter + " is too exhaustive to attack", displayLength: 2000})
        }
    })
}

function eat(playerCharacter, stamina) {
    
    let playerItems = getItems(playerCharacter)
    

    var data = {
            'action': 'ajaxEat',
            'player': playerCharacter,
            'playerItems': JSON.stringify(playerItems),
            'stamina': stamina.text()
        }
    
    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function (result) {
        result = JSON.parse(result)
        var error = result["error"]
        var stamina = result["stamina"]

        if (playerCharacter == heroeName) {
            heroeStamina.text(stamina)
        } else {
            monsterStamina.text(stamina)
        }

        if (error == 1) {
            M.toast({html: playerCharacter + " is full of energy", displayLength: 2000})
        } else {
            changePlayer()
        }

        
    })
}

function sleep(playerCharacter, stamina, hp) {
    
    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: {
            'action': 'ajaxSleep',
            'player': playerCharacter,
            'stamina': stamina.text(),
            'hp': hp.text()
        }
    }).done(function(result) {
        result = JSON.parse(result)
        var error = result["error"]
        var stamina = result["stamina"]
        var hp = result["hp"]

        if (playerCharacter == heroeName && error != 3) {
            heroeStamina.text(stamina)
            heroeHp.text(hp)
            changePlayer()
        } else if (playerCharacter == monsterName && error != 3){
            monsterStamina.text(stamina)
            monsterHp.text(hp)
            changePlayer()
        }

        if (error == 1) {
            M.toast({html: playerCharacter + " is full of energy", displayLength: 2000})
        }

        if (error == 2) {
            M.toast({html: playerCharacter + " is totally cured", displayLength: 2000})
        }

        if (error == 3) {
            M.toast({html: playerCharacter + " is totally cured, he wakes up", displayLength: 2000})
        }

        
    })
}

function run(playerCharacter) {
    var coord;
    

    if (playerCharacter == heroeName) {
        coord = heroeCoord
        stamina = heroeStamina.text()
        enemy = monsterName
        enemyCoord = monsterCoord
    } else {
        coord = monsterCoord
        stamina = monsterStamina.text()
        enemy = heroeName
        enemyCoord = heroeCoord
    }

    items = getItems(playerCharacter)

    let data = {
        'action': 'ajaxRunAway',
        'player': playerCharacter,
        'originCoordinate': coord,
        'enemy': enemy,
        'stamina': stamina,
        'playerItems' : JSON.stringify(items),
        'enemyCoord': enemyCoord
    }

    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function(result) {
        result = JSON.parse(result)
        var error = result["error"];
        var newCoord = result["coord"];
        var stamina = result["stamina"];
        
        if (playerCharacter == heroeName) {
            heroeStamina.text(stamina)
            for (let index = 0; index < bg.length; index++) {
                let element = bg[index]
                //console.log(element.dataset)
                if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == newCoord[0]) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == newCoord[1]) && error == 0) {
                        img = document.createElement("img")
                        img.src = "img/"+heroeName+".webp"
                        img.style = "width: 100%; position: absolute"
                        element.appendChild(img)
                        heroeCoord = newCoord
                    
                }
            }
        } else {
            monsterStamina.text(stamina)
            for (let index = 0; index < bg.length; index++) {
                let element = bg[index]
                if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == newCoord[0]) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == newCoord[1]) && error == 0) {
                        img = document.createElement("img")
                        img.src = "img/"+monsterName+".webp"
                        img.style = "width: 100%; position: absolute"
                        element.appendChild(img)
                        monsterCoord = newCoord
                }
            }
        }

        if(error == 0) {
            for (let index = 0; index < bg.length; index++) {
                const element = bg[index];
                if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == coord[0]) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == coord[1])) {
                    element.removeChild(element.childNodes[1])
                }
            }
            changePlayer();
        }

        if(error == 1) {
            M.toast({html: playerCharacter + " is completly exhaustive", displayLength: 2000})
        } 
    })
}

function move(playerCharacter, direction) {
    var coord;
    

    if (playerCharacter == heroeName) {
        coord = heroeCoord
        stamina = heroeStamina.text()
        enemy = monsterName
        enemyCoord = monsterCoord
    } else {
        coord = monsterCoord
        stamina = monsterStamina.text()
        enemy = heroeName
        enemyCoord = heroeCoord
    }

    items = getItems(playerCharacter)

    let data = {
        'action': 'ajaxMove',
        'player': playerCharacter,
        'originCoordinate': coord,
        'direction': direction,
        'enemy': enemy,
        'stamina': stamina,
        'playerItems' : JSON.stringify(items),
        'enemyCoord': enemyCoord
    }

    console.log(data)

    return $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function(result) {
        result = JSON.parse(result)
        var error = result["error"];
        var newCoord = result["coord"];
        var stamina = result["stamina"];
        
        if (playerCharacter == heroeName) {
            heroeStamina.text(stamina)
            for (let index = 0; index < bg.length; index++) {
                let element = bg[index]
                //console.log(element.dataset)
                if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == newCoord[0]) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == newCoord[1]) && error == 0) {
                        img = document.createElement("img")
                        img.src = "img/"+heroeName+".webp"
                        img.style = "width: 100%; position: absolute"
                        element.appendChild(img)
                        heroeCoord = newCoord
                        $("#heroe .button.move").addClass('disable')
                }
            }
            
        } else {
            monsterStamina.text(stamina)
            for (let index = 0; index < bg.length; index++) {
                let element = bg[index]
                if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == newCoord[0]) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == newCoord[1]) && error == 0) {
                        img = document.createElement("img")
                        img.src = "img/"+monsterName+".webp"
                        img.style = "width: 100%; position: absolute"
                        element.appendChild(img)
                        monsterCoord = newCoord
                        $("#monster .button.move").addClass('disable')
                }
            }
            
        }
        if(error == 0) {
            for (let index = 0; index < bg.length; index++) {
                const element = bg[index];
                if ((typeof element.dataset.posx !== 'undefined' && element.dataset.posx == coord[0]) && (typeof element.dataset.posy !== 'undefined' && element.dataset.posy == coord[1])) {
                    element.removeChild(element.childNodes[1])
                }
            }
        } else if(error == 2) {
            M.toast({html: "You are completly exhaustive", displayLength: 2000})
        } else {
            M.toast({html: "Something is blocking the way", displayLength: 2000})
        }
        
    })
}

function getItems(playerCharacter) {
    playerItems = []
    
    if (playerCharacter == heroeName) {
        var items = $('.fight-heroe-item img')
    } else {
        var items = $('.fight-monster-item img')
    }

    console.log(items)

    for (let index = 0; index < items.length; index++) {
        const element = items[index];
        playerItems.push({ [element.dataset.type] : element.name})
    }

    return playerItems
}

function changeItem(playerCharacter, type, item) {
    
    var playerItems = getItems(playerCharacter)

    var data = {
        'action': 'ajaxChangeItem',
        'player': playerCharacter,
        'playerItems': JSON.stringify(playerItems),
        'type': type,
        'item': item
    }

    $.ajax({
        method: 'post',
        url: 'main.php',
        data: data
    }).done(function(result) {
        result = JSON.parse(result)
        if (type == "weapon") {
            if (playerCharacter == heroeName) {
                $("#heroe .weaponName").text(result["name"])
                $("#heroe .damage").text(result["damage"])
            } else {
                $("#monster .weaponName").text(result["name"])
                $("#monster .damage").text(result["damage"])
            }
        } else if (type == "shield") {
            if (playerCharacter == heroeName) {
                $("#heroe .shieldName").text(result["name"])
                $("#heroe .percentDefense").text(result["percentDefense"])
            } else {
                $("#monster .shieldName").text(result["name"])
                $("#monster .damage").text(result["percentDefense"])
            }
        }
    })
}

player = chooseFirstPlayer()


takePlace();

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
        $("#fight input[name='heroeItems']").val(JSON.stringify(heroeItems))
        $("#fight input[name='monster']").val(actifMonster)
        $("#fight input[name='monsterItems']").val(JSON.stringify(monsterItems))
        $("#fight").submit()
    }
    
})

// HEROE EVENT ACTIONS
$("#heroe .move").click(function(e){
    e.preventDefault();

    move(heroeName, $(this)[0].dataset.move)
})

$("#heroe .eat").click(function(e) {
    e.preventDefault();

    eat(heroeName, heroeStamina)
})

$("#heroe .sleep").click(function(e) {
    e.preventDefault();

    sleep(heroeName, heroeStamina, heroeHp)
})

$("#heroe .run").click(function(e) {
    e.preventDefault()

    run(heroeName)
})

$("#heroe .attack").click(function(e) {
    e.preventDefault()

    attack(heroeName)
})

$(".fight-heroe-item").click(function(e) {
    e.preventDefault();

    let item = this.querySelector("img")
    let itemName = item.name
    let itemType = item.dataset.type

    console.log(item)

    changeItem(heroeName, itemType, itemName)
})

// MONSTER EVENT ACTIONS
$("#monster .move").click(function(e){
    e.preventDefault();

    move(monsterName, $(this)[0].dataset.move)
})

$("#monster .eat").click(function(e) {
    e.preventDefault();

    eat(monsterName, monsterStamina)
})

$("#monster .sleep").click(function(e) {
    e.preventDefault();

    sleep(monsterName, monsterStamina, monsterHp)
})

$("#monster .run").click(function(e) {
    e.preventDefault()

    run(monsterName)
})

$("#monster .attack").click(function(e) {
    e.preventDefault()

    attack(monsterName)
})

$(".fight-monster-item").click(function(e) {
    e.preventDefault();

    let item = this.querySelector("img")
    let itemName = item.name
    let itemType = item.dataset.type

    changeItem(monsterName, itemType, itemName)
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