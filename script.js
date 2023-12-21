var isdicelocked = [false, false, false, false, false, false];
var player1score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var rollCounter = 0;
var player2score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var diceScore = [0,0,0,0,0,0];
var activePlayer = 'a';
function rollDices() {
    for (var i = 0; i < isdicelocked.length; i++) {
      if (isdicelocked[i] == false) {
        var rnd = Math.floor(Math.random() * 6) + 1;
        diceScore[i] = rnd;
        var rnd_str = "url('images/dice" + rnd.toString() + ".png')";
        document.getElementById("dice" + (i + 1)).style.backgroundImage = rnd_str;
      }
    }
    console.log(activePlayer);
    rollCounter++;
    if (rollCounter == 3){
      rollCounter = 0;
      for (var i = 0; i < isdicelocked.length; i++) {
        isdicelocked[i] = false;
      }
      if (activePlayer == spieler1){
        activePlayer = spieler2;
        console.log(spieler1);
      }
      else{
        activePlayer = spieler1;
        console.log(spieler2);
      }
      window.location.href = "game.php?activePlayer=" + activePlayer;
    }
  }

  function holdDice(buttonId){
    button = document.getElementById("dice" + (buttonId + 1));
    if (isdicelocked[buttonId] == false){
      isdicelocked[buttonId] = true;
      document.getElementById("dice" + (buttonId + 1)).style.backgroundImage = "url('images/dice"+ diceScore[buttonId] + "_marked.png')";
    }
    else{
      isdicelocked[buttonId] = false;
      document.getElementById("dice" + (buttonId + 1)).style.backgroundImage = "url('images/dice"+ diceScore[buttonId] + ".png')";
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