<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <title>Henris Würfelspiel</title> 

    <link id="style1" rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body class="container">
  <h1 id="h1" class="item">Das Spiel ist vorbei!</h1>
  
  <div class="container">
    <?php

        $servername = "localhost";
        $username = "root";
        $password = "";

        // ##### Create connection #####
        $conn = mysqli_connect($servername, $username, $password, "kniffel");

        $sql = "SELECT * FROM `score` ORDER BY `score`.`id` DESC LIMIT 1";
        $result1 = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result1);
        $player1 = $row1['playername'];
        $player1score = $row1['gesamt'];

        $sql = "SELECT * FROM `score` ORDER BY `score`.`id` DESC LIMIT 1,1";
        $result2 = mysqli_query($conn, $sql);
        $row2 = mysqli_fetch_assoc($result2);
        $player2 = $row2['playername'];
        $player2score = $row2['gesamt'];

        if ($player1score > $player2score) {
            echo "<label class='item'>Spieler $player1 hat gewonnen!</label>";
        } else if ($player1score < $player2score) {
            echo "<label class='item'>Spieler $player2 hat gewonnen!</label>";
        } else if ($player1score == $player2score){
            echo "<label class='item'>Unentschieden! Beide Spieler haben $player1Score Punkte erreicht</label>";
        }
        else {
            echo "<label class='item'>Fehler!</label>";
        }

    ?>
    <br>
    <button class="button" onclick="exitGame()">Erneut Spielen</button>
    </div>
</body>

</html>
