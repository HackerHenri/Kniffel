var isdicelocked = [false, false, false, false, false];
var player1score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var player1locked = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var rollCounter = 0;
var player2score = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var player2locked = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var diceScore = [0,0,0,0,0];
var activePlayer = 1;
var activePlayerName = "";

function rollDices() {
    // if (activePlayerName == ""){
    //   activePlayerName = spieler1;
    //   activePlayer = 1;
    //   for (var i = 0; i < isdicelocked.length; i++) {
    //     document.getElementById("dice"+(i+1)).disabled = false;
    //   }
    // }
  for (var i = 0; i < isdicelocked.length; i++) {
    document.getElementById("dice"+(i+1)).disabled = false;
  }

    for (var i = 0; i < isdicelocked.length; i++) {
      if (isdicelocked[i] == false) {
        var rnd = Math.floor(Math.random() * 6) + 1;
        diceScore[i] = rnd;
        var rnd_str = "url('images/dice" + rnd.toString() + ".png')";
        console.log(rnd_str);
        document.getElementById("dice" + (i + 1)).style.backgroundImage = rnd_str;
      }
    }
    console.log(diceScore);
    checkScoreButtons(activePlayer);
    checkDropButtons(activePlayer);
    checkSpecialScoreButtons();
    rollCounter++;
    if (rollCounter == 3){
      document.getElementById("roll").disabled = true;
      rollCounter = 0;
    }

  }

  function holdDice(buttonId){
    if (isdicelocked[buttonId] == false){
      isdicelocked[buttonId] = true;
      document.getElementById("dice" + (buttonId + 1)).style.backgroundImage = "url('images/dice"+ diceScore[buttonId] + "_marked.png')";
      console.log("Dice " + (buttonId + 1) + " locked");
      console.log(buttonId);
      console.log(diceScore);
      console.log("images/dice"+ diceScore[buttonId] + "_marked.png");
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
    if (field == 1)
    {
      oneToSix(1);
    }
    if (field == 2)
    {
      oneToSix(2);
    }
    if (field == 3)
    {
      oneToSix(3);
    }
    if (field == 4)
    {
      oneToSix(4);
    }
    if (field == 5)
    {
      oneToSix(5);
    }
    if (field == 6)
    {
      oneToSix(6);
    }
    if (field == 7)
    {
      sum = countAllEyes();
      if (activePlayer == 1){
        player1score[6] = sum;
      }
      else{
        player2score[6] = sum;
      }
    }
    if (field == 8)
    {
      sum = countAllEyes();
      if (activePlayer == 1){
        player1score[7] = sum;
      }
      else{
        player2score[7] = sum;
      }
    }
    if (field == 9)
    {
      sum = 25;
      if (activePlayer == 1){
        player1score[8] = sum;
      }
      else{
        player2score[8] = sum;
      }
    }
    if (field == 10)
    {
      sum = 30;
      if (activePlayer == 1){
        player1score[9] = sum;
      }
      else{
        player2score[9] = sum;
      }
    }
    if (field == 11)
    {
      sum = 40;
      if (activePlayer == 1){
        player1score[10] = sum;
      }
      else{
        player2score[10] = sum;
      }
    }
    if (field == 12)
    {
      sum = 50;
      if (activePlayer == 1){
        player1score[11] = sum;
      }
      else{
        player2score[11] = sum;
      }
    }
    if (field == 13)
    {
      sum = countAllEyes();
      if (activePlayer == 1){
        player1score[12] = sum;
      }
      else{
        player2score[12] = sum;
      }
    }
    console.log("field " + field);
    console.log("score " + player1score);
    console.log("score2 " + player2score);
    console.log("activePlayer " + activePlayer);
    const [sumTop, sumBottom, bonus, totalTop, total] = calculateSums();
    if (activePlayer == 1){
      sendScore = player1score[field-1];
    }
    else{
      sendScore = player2score[field-1];
    }

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "scoreToServer.php?score="+sendScore+"&field="+(field-1)+"&player="+activePlayerName+"&sumTop="+sumTop+"&sumBottom="+sumBottom+"&bonus="+bonus+"&sum="+total+"&totalTop="+totalTop, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };
    document.getElementById("score_button" + (field)).disabled = true;
    document.getElementById("drop_button" + (field)).disabled = true;
    if (activePlayer == 1){
      player1locked[field-1] = 1;
    }
    else{
      player2locked[field-1] = 1;
    }

    nextPlayer();
  }

  function calculateSums(){
    if (activePlayer == 1){
      score = player1score;
    }
    else{
      score = player2score;
    }
    var sumTop = 0;
    var totalTop = 0;
    var sumBottom = 0;
    var bonus = 0;
    var total = 0;

    for (var i = 0; i < 6; i++) {
      sumTop += score[i];
    }
    if (sumTop >= 63){
      bonus = 35;
    }
    for (var i = 6; i < 13; i++) {
      sumBottom += score[i];
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

  function checkDropButtons(player){
    if (player == 1){
      for (var i = 0; i < player1score.length; i++) {
        if(player1locked[i] != 0){
          document.getElementById("drop_button" + (i+1)).disabled = true;
        }
        else{
          document.getElementById("drop_button" + (i+1)).disabled = false;
        }
      }

    } 
    else{
      for (var i = 0; i < player2score.length; i++) {
        if(player2locked[i] != 0){
          document.getElementById("drop_button" + (i+1)).disabled = true;
        }
        else{
          document.getElementById("drop_button" + (i+1)).disabled = false;
        }
      }
    }
  }

  function checkNumberFrequency(number, freq) {
    var count = 0;
    for (var i = 0; i < diceScore.length; i++) {
      if (diceScore[i] == number) {
        count++;
        if (count >= freq) {
          return true;
        }
      }
    }
    return false;
  }

  function checkPasch(n){
    for (var i=0; i<diceScore.length; i++){
      if (checkNumberFrequency(i, n)){
        console.log(n + "er "+"Pasch");
        return true;
      }
    }
    return false;
  }
  
  function checkFullHouse(){
    var counter = 0;
    var counter2 = 0;
    for (var i = 0; i < diceScore.length; i++) {
      if (checkNumberFrequency(diceScore[i], 3)){
        counter++;
      }
      else if (checkNumberFrequency(diceScore[i], 2)){
        counter2++;
      }
      else{
        return false;
      }
    }
    if ((counter > 0) && (counter2 > 0)){
      console.log("Full House");
      return true;

    }
    else{
      return false;
    }
  }

  function checkKniffel(){
    if (checkNumberFrequency(diceScore[0], 5)){
      console.log("Kniffel");
      return true;
    }
    else{
      return false;
    }
  }
  function checkStreet(n){
    // für n = 3: 1,2,3,4 oder 2,3,4,5 oder 3,4,5,6
    // für n = 4: 1,2,3,4,5 oder 2,3,4,5,6
    var diceScore_sort = diceScore.slice().sort();
    counter = 0;
    for (var i = 0; i < diceScore_sort.length; i++){
      if (diceScore_sort[i] == diceScore_sort[i+1] - 1){
        counter++;
      }
    }
    if (counter >= n){
      console.log(n + "er "+"Street");
      return true;
    }
    else{
      return false;
    }   
  }

  function dropResult(field){
    if (activePlayer == 1){
      player1locked[field-1] = 1;
    }
    else{
      player2locked[field-1] = 1;
    }
    document.getElementById("score_button" + (field)).disabled = true;
    document.getElementById("drop_button" + (field)).disabled = true;

  }

  function disableButtons(){
    for (var i = 0; i < player1locked.length; i++) {
      document.getElementById("score_button" + (i+1)).disabled = true;
      document.getElementById("drop_button" + (i+1)).disabled = true;
    }
  }

  function nextPlayer(){
    disableButtons();
    for (var i = 0; i < isdicelocked.length; i++) {
      if (isdicelocked[i] == true){
        holdDice(i);
      }
      isdicelocked[i] = false;
    }
    if (activePlayer == 1){
      activePlayer = 2;
      activePlayerName = spieler2;
      // document.getElementById("player").innerHTML = spieler2 + " ist am Zug!";
      console.log(spieler1);
    }
    else{
      activePlayer = 1;
      activePlayerName = spieler1;
      // document.getElementById("player").innerHTML = spieler1 + " ist am Zug!";
      console.log(spieler2);
    }
    document.getElementById("roll").disabled = false;

    // Ralode game.php
    location.reload(true)


  }

  function checkSpecialScoreButtons(){
    if (!(checkPasch(3))){
      document.getElementById("score_button7").disabled = true;
    }
    if (!(checkPasch(4))){
      document.getElementById("score_button8").disabled = true;
    }
    if (!(checkFullHouse())){
      document.getElementById("score_button9").disabled = true;
    }
    if (!(checkStreet(3))){
      document.getElementById("score_button10").disabled = true;
    }
    if (!(checkStreet(4))){
      document.getElementById("score_button11").disabled = true;
    }
    if (!(checkKniffel())){
      document.getElementById("score_button12").disabled = true;
    }
  }

  function oneToSix(n){
    for (var i = 0; i < diceScore.length; i++) {
      if (diceScore[i] == n){
        if (activePlayer == 1){
          player1score[n-1] += n;
        }
        else{
          player2score[n-1] += n;
        }
      }
    }
  }

  function countAllEyes(){
    var sum = 0;
    for (var i = 0; i < diceScore.length; i++) {
      sum += diceScore[i];
    }
    return sum;
  }