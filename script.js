var isdicelocked = [0, 0, 0, 0, 0];
var playerscore = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var buttonslocked = [0,0,0,0,0,0,0,0,0,0,0,0,0];
var rollCounter = 0;
var diceScore = [0,0,0,0,0];
var activePlayer = 1;
var activePlayerName = "";

window.onload = function() {
  if (rollCounter !== 0) {
    for (let i = 1; i <= 5; i++) {
      document.getElementById('dice' + i).disabled = false;
    }
    checkScoreButtons(activePlayer);
    checkSpecialScoreButtons();
  }
}

function rollDices() {
  for (var i = 0; i < isdicelocked.length; i++) {
    document.getElementById("dice"+(i+1)).disabled = false;
  }

    for (var i = 0; i < isdicelocked.length; i++) {
      if (isdicelocked[i] == 0) {
        var rnd = Math.floor(Math.random() * 6) + 1;
        diceScore[i] = rnd;
        var rnd_str = "url('images/dice" + rnd.toString() + ".png')";
        console.log(rnd_str);
        document.getElementById("dice" + (i + 1)).style.backgroundImage = rnd_str;
      }
    }
    console.log(diceScore);
    console.log(isdicelocked);
    checkScoreButtons(activePlayer);
    checkSpecialScoreButtons();
    rollCounter++;

    if (rollCounter >= 3){
      document.getElementById("roll").disabled = true;
    }
  sendActiveRound();
  }

  function holdDice(buttonId){

    if (isdicelocked[buttonId] == 0){
      isdicelocked[buttonId] = 1;
      document.getElementById("dice" + (buttonId + 1)).style.backgroundImage = "url('images/dice"+ diceScore[buttonId] + "_marked.png')";
    }
    else{
      isdicelocked[buttonId] = 0;
      document.getElementById("dice" + (buttonId + 1)).style.backgroundImage = "url('images/dice"+ diceScore[buttonId] + ".png')";
    }
    sendActiveRound();
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
      if (checkPasch(3))
      {
        sum = countAllEyes();
      }
      else
      {
        sum = 0;
      }
      playerscore[6] = sum;
    }
    if (field == 8)
    {
      if (checkPasch(4))
      {
        sum = countAllEyes();
      }
      else
      {
        sum = 0;
      }
      playerscore[7] = sum;
    }
    if (field == 9)
    {
      if (checkFullHouse())
      {
        sum = 25;
      }
      else
      {
        sum = 0;
      }
      playerscore[8] = sum;
    }

    if (field == 10)
    {

      if (checkStreet(3))
      {
        sum = 30;
      }
      else
      {
        sum = 0;
      }
      playerscore[9] = sum;
    }
    if (field == 11)
    {
      if (checkStreet(4))
      {
        sum = 40;
      }
      else
      {
        sum = 0;
      }
      playerscore[10] = sum;
    }
    if (field == 12)
    {
      if (checkKniffel())
      {
        sum = 50;
      }
      else
      {
        sum = 0;
      }
      playerscore[11] = sum;
    }
    if (field == 13)
    {
      sum = countAllEyes();
      playerscore[12] = sum;
    }
    console.log("field " + field);
    console.log("score " + playerscore);
    console.log("activePlayer " + activePlayer);
    const [sumTop, sumBottom, bonus, totalTop, total] = calculateSums();
    sendScore = playerscore[field-1];

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "scoreToServer.php?score="+sendScore+"&field="+(field-1)+"&player="+activePlayerName+"&sumTop="+sumTop+"&sumBottom="+sumBottom+"&bonus="+bonus+"&sum="+total+"&totalTop="+totalTop, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };

    // reload game.php -> problem: sometimes the reload ist faster then the server response (writing to database)
    // -> solution: reload after 200 ms
    setTimeout(reload, 200);
  }
  function reload(){
      location.reload(true);
  }

  function calculateSums(){
    var sumTop = 0;
    var totalTop = 0;
    var sumBottom = 0;
    var bonus = 0;
    var total = 0;

    for (var i = 0; i < 6; i++) {
      sumTop += playerscore[i];
    }

    if (sumTop >= 63){
      bonus = 35;
    }
    for (var i = 6; i < 13; i++) {
      sumBottom += playerscore[i];
    }

    total = sumTop + sumBottom + bonus;
    totalTop = sumTop + bonus;
    return [sumTop, sumBottom, bonus, totalTop, total]
  }

  function checkScoreButtons(player){
    for (var i = 0; i < playerscore.length; i++) {
      if (buttonslocked[i] == 0){
        document.getElementById("score_button" + (i+1) + "_" + activePlayer).disabled = false;
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
    for (var i=1; i<=6; i++){
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

  function checkSpecialScoreButtons(){
    if ((checkPasch(3)) && buttonslocked[6] == 0)
      document.getElementById("score_button7_" + activePlayer ).style.borderColor = "red";
    else
        document.getElementById("score_button7_" + activePlayer ).style.borderColor = "transparent";

    if ((checkPasch(4)) && buttonslocked[7] == 0)
      document.getElementById("score_button8_" + activePlayer).style.borderColor = "red";
    else
        document.getElementById("score_button8_" + activePlayer).style.borderColor = "transparent";

    if ((checkFullHouse()) && buttonslocked[8] == 0)
      document.getElementById("score_button9_" + activePlayer).style.borderColor = "red";
    else
        document.getElementById("score_button9_" + activePlayer).style.borderColor = "transparent";

    if ((checkStreet(3)) && buttonslocked[9] == 0)
      document.getElementById("score_button10_" + activePlayer).style.borderColor = "red";
    else
        document.getElementById("score_button10_" + activePlayer).style.borderColor = "transparent";

    if ((checkStreet(4)) && buttonslocked[10] == 0)
      document.getElementById("score_button11_" + activePlayer).style.borderColor = "red";
    else
        document.getElementById("score_button11_" + activePlayer).style.borderColor = "transparent";

    if ((checkKniffel()) && buttonslocked[11] == 0)
      document.getElementById("score_button12_" + activePlayer).style.borderColor = "red";
    else
        document.getElementById("score_button12_" + activePlayer).style.borderColor = "transparent";

  }

  function oneToSix(n){
    for (var i = 0; i < diceScore.length; i++) {
      if (diceScore[i] == n){
        playerscore[n-1] += n;
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

  function sendActiveRound(){
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "activeroundToServer.php?dicelocked1="+isdicelocked[0]+"&dicelocked2="+isdicelocked[1]+"&dicelocked3="+isdicelocked[2]+"&dicelocked4="+isdicelocked[3]+"&dicelocked5="+isdicelocked[4]+"&rollCounter="+rollCounter+"&diceScore1="+diceScore[0]+"&diceScore2="+diceScore[1]+"&diceScore3="+diceScore[2]+"&diceScore4="+diceScore[3]+"&diceScore5="+diceScore[4], true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };
  }