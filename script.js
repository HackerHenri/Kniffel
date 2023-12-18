var isdicelocked = [false, false, false, false, false, false];
var player1score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var rollCounter = 0;
var player2score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var diceScore = [0,0,0,0,0,0];
function rollDices() {
    for (var i = 0; i < isdicelocked.length; i++) {
      if (isdicelocked[i] == false) {
        var rnd = Math.floor(Math.random() * 6) + 1;
        diceScore[i] = rnd;
        var rnd_str = "url('dice" + rnd.toString() + ".png')";
        document.getElementById("dice" + (i + 1)).style.backgroundImage = rnd_str;
      }
    }
    rollCounter++;
    if (rollCounter == 3){
      rollCounter = 0;
      for (var i = 0; i < isdicelocked.length; i++) {
        isdicelocked[i] = false;
        document.getElementById("holdButton" + (i + 1)).style.backgroundColor = "grey";
      }
      if (document.getElementById("player").innerHTML == spieler1 + " ist am Zug!"){
        document.getElementById("player").innerHTML = spieler2 + " ist am Zug!";
      }
      else{
        document.getElementById("player").innerHTML = spieler1 + " ist am Zug!";
      }
    }
  }

  function holdDice(buttonId){
    button = document.getElementById("holdButton" + (buttonId + 1));
    if (isdicelocked[buttonId] == false){
      isdicelocked[buttonId] = true;
      document.getElementById("holdButton" + (buttonId + 1)).style.backgroundColor = "red";
    }
    else{
      isdicelocked[buttonId] = false;
      document.getElementById("holdButton" + (buttonId + 1)).style.backgroundColor = "grey";
    }
  }

  function endRound(){
    //TODO
  }
  function selectResult(field, player, score){
    //TODO
    if (result == 1)
    {}

  }