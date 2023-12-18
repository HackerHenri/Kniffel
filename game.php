<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Henris Würfelspiel</title> 
    <link id="style1" rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <style>
        .dice {
            display: inline-block;
            width: 50px;
            height: 50px;
            background-repeat: no-repeat;
            background-size: contain;
        }
        #dice1 {
            background-image: url("images/dice1.png");
        }
        #dice2 {
            background-image: url("images/dice2.png");
        }
        #dice3 {
            background-image: url("images/dice3.png");
        }
        #dice4 {
            background-image: url("images/dice4.png");
        }
        #dice5 {
            background-image: url("images/dice5.png");
        }
        #dice6 {
            background-image: url("images/dice6.png");
        }
        table, th, tr, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
        .holdButton{
          width: 100px;
          height: 100px;
          background-color: grey;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    // Create connection
    // $conn = mysqli_connect($servername, $username, $password, "kniffel");

    // Check connection
    // if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
    // }
    // $sql = "INSERT INTO `kniffel`.`Meta` (`Spieler1`, `Spieler2`) VALUES ('x', 'y');";
    // $result = mysqli_query($conn, $sql);
    // if ($result) {
    // } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    //     }
    // $conn->close();

    ?>

    <h1>Kniffelspaß!</h1>
    <?php
        $spieler1 = $_POST["spieler1"];
        $spieler2 = $_POST["spieler2"];
        echo "<script>var spieler1 = '$spieler1';</script>";
        echo "<script>var spieler2 = '$spieler2';</script>";

        $active_player = $spieler1;
        echo "<h2 id='player'>$active_player ist am Zug!</h2>";
        echo "<h2>$spieler1 vs. $spieler2</h2>";
    ?>


    <?php
        $score1 = array(
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
            17 => 0
        );
        $score2 = array(
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
            17 => 0
        );
        ?>


        <main id="boxes" style="display: flex; flex-direction: row;"> 
        <div style="display: flex; flex-direction: column;">
            <div id="dice1_box" style="display: flex; flex-direction: row;">
                <button class="dice" id="dice1" onclick="holdDice(0)"></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice2" onclick="holdDice(1)"></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice3" onclick="holdDice(2)"></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice4" onclick="holdDice(3)"></button>
            </div>

            <div  style="display: flex; flex-direction: row;">
                <button class="dice" id="dice5" onclick="holdDice(4)"></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice6" onclick="holdDice(5)"></button>
            </div>
        </div>

        <div class="ergebnis" style="display: flex; flex-direction: column; justify-content: space-around;">
            <table>
            <thead>
                <tr>
                <th>Kniffel</th>
                <th>1er</th>
                <th>2er</th>
                <th>3er</th>
                <th>4er</th>
                <th>5er</th>
                <th>6er</th>
                <th>Summe oben</th>
                <th>Bonus (63+)</th>
                <th>Gesamt oben</th>
                <th>3er Pasch</th>
                <th>4er Pasch</th>
                <th>Full House</th>
                <th>Kleine Straße</th>
                <th>Große Straße</th>
                <th>Kniffel</th>
                <th>Chance</th>
                <th>Gesamt unten</th>
                <th>Gesamt</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td id=player1>Spieler 1</td>
                <?php
                    for ($i = 0; $i < 18; $i++) {
                        echo "<td id='player1_$i'>$score1[$i]</td>";
                    }
                ?>
                </tr>
                <tr>
                <td id=player2>Spieler 2</td>
                <?php
                    for ($i = 0; $i < 18; $i++) {
                        echo "<td id='player2_$i'>$score2[$i]</td>";
                    }
                ?>
                </tr>
                <tr>
                    <td id=ergebnisButtons>Wählen</td>
                    <td id='ergebnis1'><form method='post'>  <input type='hidden' name='score1' value='3487'>
                            <button type='submit'>Wählen</button></form></td>
                    <?php
                        $var = $_POST["score1"];
                     
                        // for ($i = 0; $i < 18; $i++) {
                        //     echo "<td id='ergebnis_$i'><form method='post' action='game.php'>  <input type='hidden' name='score' value='3487'>
                        //     <button type='submit'>Wählen</button></form></td>";
                        // }
                    ?>
            </tbody>
            </table>
            <button style="width:25%;heigth:1000px;" onclick="rollDices()">Würfeln</button>
            <button style="width:25%;heigth:1000px;" onclick="endRound()">Runde beenden!</button>
        </div>
        </main>
    </body>
</html>
