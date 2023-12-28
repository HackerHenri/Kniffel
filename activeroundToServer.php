<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, "kniffel");

$isdicelocked1 = $_GET['dicelocked1'];
$isdicelocked2 = $_GET['dicelocked2'];
$isdicelocked3 = $_GET['dicelocked3'];
$isdicelocked4 = $_GET['dicelocked4'];
$isdicelocked5 = $_GET['dicelocked5'];
$rollCounter = $_GET['rollCounter'];
$diceScore1 = $_GET['diceScore1'];
$diceScore2 = $_GET['diceScore2'];
$diceScore3 = $_GET['diceScore3'];
$diceScore4 = $_GET['diceScore4'];
$diceScore5 = $_GET['diceScore5'];
$sql = "UPDATE `activeround` SET `dicelocked1`=$isdicelocked1,`dicelocked2`=$isdicelocked2,`dicelocked3`=$isdicelocked3,`dicelocked4`=$isdicelocked4,`dicelocked5`=$isdicelocked5,`rollCounter`=$rollCounter,`diceScore1`=$diceScore1,`diceScore2`=$diceScore2,`diceScore3`=$diceScore3,`diceScore4`=$diceScore4,`diceScore5`=$diceScore5 WHERE 1";
$result = mysqli_query($conn, $sql);


?>