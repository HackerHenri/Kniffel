<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <title>Henris Würfelspiel</title> 

    <link id="style1" rel="stylesheet" href="style.css">
</head>

<body class="container">
  <h1 id="h1" class="item">Würfelspiel Kniffel</h1>

  <div class="container">
  <form method="post" action="index.php">
    <label class="item">Spielername 1:</label>
    <input class="item" type="text" name="spieler1" placeholder="Enter player 1 name">
    <br>
    <label class="item">Spielername 2:</label>
    <input class="item" type="text" name="spieler2" placeholder="Enter player 2 name">
    <br>
    </div>
    <div class="container">
    <button class="button" type="submit">Spiel Starten!</button>
    </div>
  </form>
</body>

</html>

<?php
  $spieler1 = $_POST["spieler1"];
  $spieler2 = $_POST["spieler2"];

  $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, "kniffel");

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    // Delete all tasks
    // $sql = 'DELETE * FROM score';

    // // Enter Data
    // $sql = "INSERT INTO `kniffel`.`Meta` (`Spieler1`, `Spieler2`) VALUES ('x', 'y');";
    // $result = mysqli_query($conn, $sql);
    // if ($result) {
    // } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    //     }
    $conn->close();

?>