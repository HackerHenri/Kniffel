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

    <h1>Kniffelspaß!</h1>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";

        // Create connection
         $conn = mysqli_connect($servername, $username, $password, "kniffel");

        $sql = "SELECT * FROM `score` WHERE 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $player1 = $row['playername'];

        $row = mysqli_fetch_assoc($result);
        $player2 = $row['playername'];

        // get second last entry for active player
        $sql = "SELECT * FROM `score` ORDER BY `score`.`id` DESC LIMIT 1, 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $activePlayer = $row['playername'];


        // ##### Get Score from Player1 #####
        $sql = "SELECT * FROM `score` WHERE `playername` = '$player1' ORDER BY `score`.`id` DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $score1 = array(
            0 => $row['1er'],
            1 => $row['2er'],
            2 => $row['3er'],
            3 => $row['4er'],
            4 => $row['5er'],
            5 => $row['6er'],
            6 => $row['summe_oben'],
            7 => $row['bonus'],
            8 => $row['gesamt_oben'],
            9 => $row['3er_pasch'],
            10 => $row['4er_pasch'],
            11 => $row['full_house'],
            12 => $row['kleine_strasse'],
            13 => $row['grosse_strasse'],
            14 => $row['kniffel'],
            15 => $row['chance'],
            16 => $row['gesamt_unten'],
            17 => $row['gesamt'],
        );
        for ($i = 0; $i < 18; $i++) {
            if ($score1[$i] == NULL) {
                $score1[$i] = 0;
            }
        }

        $scoreScript = array(
            0 => $row['1er'],
            1 => $row['2er'],
            2 => $row['3er'],
            3 => $row['4er'],
            4 => $row['5er'],
            5 => $row['6er'],
            6 => $row['3er_pasch'],
            7 => $row['4er_pasch'],
            8 => $row['full_house'],
            9 => $row['kleine_strasse'],
            10 => $row['grosse_strasse'],
            11 => $row['kniffel'],
            12 => $row['chance'],
        );
        for ($i = 0; $i < 13; $i++) {
            if ($scoreScript[$i] == NULL) {
                $scoreScript[$i] = 0;
            }
            else{
                $scoreScript[$i] = (int)$scoreScript[$i];
            }
        }
        $js_array = json_encode($scoreScript);
        echo"<script>var player1score = $js_array;</script>";


        // ##### Get Score from Player2 #####
        $sql = "SELECT * FROM `score` WHERE `playername` = '$player2' ORDER BY `score`.`id` DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $score2 = array(
            0 => $row['1er'],
            1 => $row['2er'],
            2 => $row['3er'],
            3 => $row['4er'],
            4 => $row['5er'],
            5 => $row['6er'],
            6 => $row['summe_oben'],
            7 => $row['bonus'],
            8 => $row['gesamt_oben'],
            9 => $row['3er_pasch'],
            10 => $row['4er_pasch'],
            11 => $row['full_house'],
            12 => $row['kleine_strasse'],
            13 => $row['grosse_strasse'],
            14 => $row['kniffel'],
            15 => $row['chance'],
            16 => $row['gesamt_unten'],
            17 => $row['gesamt'],
        );
        for ($i = 0; $i < 18; $i++) {
            if ($score2[$i] == NULL) {
                $score2[$i] = 0;
            }
        }

        $scoreScript = array(
            0 => $row['1er'],
            1 => $row['2er'],
            2 => $row['3er'],
            3 => $row['4er'],
            4 => $row['5er'],
            5 => $row['6er'],
            6 => $row['3er_pasch'],
            7 => $row['4er_pasch'],
            8 => $row['full_house'],
            9 => $row['kleine_strasse'],
            10 => $row['grosse_strasse'],
            11 => $row['kniffel'],
            12 => $row['chance'],
        );
        for ($i = 0; $i < 13; $i++) {
            if ($scoreScript[$i] == NULL) {
                $scoreScript[$i] = 0;
            }
            else{
                $scoreScript[$i] = (int)$scoreScript[$i];
            }
        }

        // copy array to javascript and transfer to integer
        $js_array = json_encode($scoreScript);
        echo"<script>var player2score = $js_array;</script>";

        // ##### Update Playernames in Script #####
        echo"<script>var spieler1 = '$player1';</script>";
        echo"<script>var spieler2 = '$player2';</script>";
        echo"<script>var activePlayerName = '$activePlayer';</script>";

        if ($activePlayer == $player1){
            echo"<script>var activePlayer = 1;</script>";
        }
        else{
            echo"<script>var activePlayer = 2;</script>";
        }

        // ##### Update Playernames in Script #####
        echo "<h2 id='player'>$activePlayer ist am Zug!</h2>";
        echo "<h2>$player1 vs. $player2</h2>";


    // ##### Get All activeRound Values #####
    $sql = "SELECT * FROM `activeround` WHERE 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Get dicelocked values
    $dicelocked = array(
        0 => (bool)$row['dicelocked1'],
        1 => (bool)$row['dicelocked2'],
        2 => (bool)$row['dicelocked3'],
        3 => (bool)$row['dicelocked4'],
        4 => (bool)$row['dicelocked5'],
    );
    $js_array = json_encode($dicelocked);
    echo"<script>var isdicelocked = $js_array;</script>";

    // get rollcounter value
    $rollCounter = (int)$row['rollCounter'];
    echo "<script>var rollCounter = $rollCounter;</script>";

    // get diceScore value
    $diceScore = array(
        0 => (int)$row['diceScore1'],
        1 => (int)$row['diceScore2'],
        2 => (int)$row['diceScore3'],
        3 => (int)$row['diceScore4'],
        4 => (int)$row['diceScore5'],
    );
    $js_array = json_encode($diceScore);
    echo"<script>var diceScore = $js_array;</script>";

    $conn->close();

    ?>




        <main id="boxes" style="display: flex; flex-direction: row;"> 
        <div style="display: flex; flex-direction: column;">
            <div id="dice1_box" style="display: flex; flex-direction: row;">
                <button class="dice" id="dice1" onclick="holdDice(0)" disabled></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice2" onclick="holdDice(1)" disabled></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice3" onclick="holdDice(2)" disabled></button>
            </div>

            <div style="display: flex; flex-direction: row;">
                <button class="dice" id="dice4" onclick="holdDice(3)" disabled></button>
            </div>

            <div  style="display: flex; flex-direction: row;">
                <button class="dice" id="dice5" onclick="holdDice(4)" disabled></button>
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
                    <?php
                    for ($i = 0; $i < 18; $i++) {
                        if ($i != 6 && $i != 7 && $i != 8 && $i != 16 && $i != 17) {
                            if($i > 6){
                                $new_i = $i - 2;
                            }
                            else{
                                $new_i = $i + 1;
                            }
                            echo "<td><button id='score_button$new_i' onclick='selectResult($new_i)' disabled>Wählen</button></td>";
                        } else {
                            echo "<td></td>";
                        }
                    }
                    ?>
                </tr>
                <tr>
                    <td id=dropButtons>Streichen</td>
                    <?php
                    for ($i = 0; $i < 18; $i++) {
                        if ($i != 6 && $i != 7 && $i != 8 && $i != 16 && $i != 17) {
                            if($i > 6){
                                $new_i = $i - 2;
                            }
                            else{
                                $new_i = $i + 1;
                            }
                            echo "<td><button id='drop_button$new_i' onclick='dropResult($new_i)' disabled>Streichen</button></td>";
                        } else {
                            echo "<td></td>";
                        }
                    }
                    ?>
            </tbody>
            </table>
            <button id="roll" style="width:25%;heigth:1000px;" onclick="rollDices()">Würfeln</button>
            <button style="width:25%;heigth:1000px;" onclick="endRound()">Runde beenden!</button>
        </div>
        </main>
    </body>
</html>
