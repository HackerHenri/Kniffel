var isdicelocked = [false, false, false, false, false, false];
var player1score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var player1locked = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var rollCounter = 0;
var player2score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var player2locked = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var diceScore = [0,0,0,0,0,0];
var activePlayer = 1;
var activePlayerName = "";
function rollDices() {
    if (activePlayerName == ""){
      activePlayerName = spieler1;
      activePlayer = 1;
    }
    checkScoreButtons(activePlayer);
    for (var i = 0; i < isdicelocked.length; i++) {
      if (isdicelocked[i] == false) {
        var rnd = Math.floor(Math.random() * 6) + 1;
        diceScore[i] = rnd;
        var rnd_str = "url('images/dice" + rnd.toString() + ".png')";
        document.getElementById("dice" + (i + 1)).style.backgroundImage = rnd_str;
      }
    }
    rollCounter++;
    if (rollCounter == 3){
      document.getElementById("roll").disabled = true;
      rollCounter = 0;
      for (var i = 0; i < isdicelocked.length; i++) {
        isdicelocked[i] = false;
      }
      if (activePlayer == 1){
        activePlayer = 2;
        activePlayerName = spieler2;
        document.getElementById("player").innerHTML = spieler2 + " ist am Zug!";
        console.log(spieler1);
      }
      else{
        activePlayer = 1;
        activePlayerName = spieler1;
        document.getElementById("player").innerHTML = spieler1 + " ist am Zug!";
        console.log(spieler2);
      }
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
  function selectResult(field){
    //TODO
    if (field == 1)
    {
      for (var i = 0; i < diceScore.length; i++) {
        if (diceScore[i] == 1){
          player1score[0] += 1;
        }
      }
      document.getElementById("score_button1").disabled = true;
    }
    if (field == 2)
    {
      for (var i = 0; i < diceScore.length; i++) {
        if (diceScore[i] == 2){
          player1score[1] += 2;
        }
      }
    }
    if (field == 3)
    {
      for (var i = 0; i < diceScore.length; i++) {
        if (diceScore[i] == 3){
          player1score[2] += 3;
        }
      }
    }
    if (field == 4)
    {
      for (var i = 0; i < diceScore.length; i++) {
        if (diceScore[i] == 4){
          player1score[3] += 4;
        }
      }
    }
    if (field == 5)
    {
      for (var i = 0; i < diceScore.length; i++) {
        if (diceScore[i] == 5){
          player1score[4] += 5;
        }
      }
    }
    if (field == 6)
    {
      for (var i = 0; i < diceScore.length; i++) {
        if (diceScore[i] == 6){
          player1score[5] += 6;
        }
      }
    }

    const [sumTop, sumBottom, bonus, total, totalTop] = calculateSums();


    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "scoreToServer.php?score="+player1score[field-1]+"&field="+(field-1)+"&player="+activePlayerName+"&sumTop="+sumTop+"&sumBottom="+sumBottom+"&bonus="+bonus+"&sum="+total+"&totalTop="+totalTop, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };

  }

  function calculateSums(){
    var sumTop = 0;
    var totalTop = 0;
    var sumBottom = 0;
    var bonus = 0;
    var total = 0;

    for (var i = 0; i < 6; i++) {
      sumTop += player1score[i];
    }
    if (sumTop >= 63){
      bonus = 35;
    }
    for (var i = 6; i < 13; i++) {
      sumBottom += player1score[i];
    }
    total = sumTop + sumBottom + bonus;
    totalTop = sumTop + bonus;
    return [sumTop, sumBottom, bonus, totalTop, total]
  }

  function checkScoreButtons(player){
    if (player == 1){
      for (var i = 0; i < player1score.length; i++) {
        if ((player1score[i] != 0) || (player1locked[i] != 0)){
          document.getElementById("score_button" + (i+1)).disabled = true;
        }
        else{
          document.getElementById("score_button" + (i+1)).disabled = false;
        }
      }
    }
    else{
      for (var i = 0; i < player2score.length; i++) {
        if ((player2score[i] != 0) || (player2locked[i] != 0)){
          document.getElementById("score_button" + (i+1)).disabled = true;
        }
        else{
          document.getElementById("score_button" + (i+1)).disabled = false;
        }
      }
    }

  }