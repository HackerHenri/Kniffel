<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Henris Würfelspiel</title> 
    <link id="style1" rel="stylesheet" href="style_game.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="item">Kniffelspaß!</h1>

        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";

    // ##### Create connection #####
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

    // ##### Get Score for script variable from activePlayer #####
            $sql = "SELECT * FROM `score` WHERE `playername` = '$activePlayer' ORDER BY `score`.`id` DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

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
            echo"<script>var playerscore = $js_array;</script>";

    // ##### Get ButtonsLocked for script variable from activePlayer #####
            $buttonslockedScript = array(
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
                if ($buttonslockedScript[$i] == NULL) {
                    $buttonslockedScript[$i] = 0;
                }
                else{
                    $buttonslockedScript[$i] = 1;
                }
            }

            // copy array to javascript and transfer to integer
            $js_array = json_encode($buttonslockedScript);
            echo"<script>var buttonslocked = $js_array;</script>";


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
            echo "<h2 class='item'>$player1 vs. $player2</h2>";


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
        <div class="item">
            <div class="item" style="flex-flow: column">

                <?php

                    for ($i = 1; $i <= 5; $i++) {
                        $diceImage = $dicelocked[$i-1] ? "images/dice{$diceScore[$i-1]}_marked.png" : "images/dice{$diceScore[$i-1]}.png";
                        echo "<div>";
                        echo "<button class='dice' id='dice$i' onclick='holdDice(" . ($i - 1) . ")' style='background-image: url($diceImage);' disabled></button>";
                        echo "</div>";
                    }
                ?>

                <button id="roll" class="standard_button" onclick="rollDices()">Würfeln</button>
            </div>

            <div class="item">
                <table>
                    <thead>
                        <tr>
                            <td class="table_cell"></td>
                            <td class="table_cell_heading"><?php echo $player1 ?></td>
                            <td class="table_cell_heading"><?php echo $player2 ?> </td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">1er</td>
                            <td><button id="score_button1_1" class="button_table" disabled onclick="selectResult(1)" ><?php echo $score1[0] ?></button></td>
                            <td><button id="score_button1_2" class="button_table" disabled onclick="selectResult(1)"><?php echo $score2[0] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">2er</td>
                            <td><button id="score_button2_1" class="button_table" disabled onclick="selectResult(2)"><?php echo $score1[1] ?></button></td>
                            <td><button id="score_button2_2" class="button_table" disabled onclick="selectResult(2)"><?php echo $score2[1] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">3er</td>
                            <td><button id="score_button3_1" class="button_table" disabled onclick="selectResult(3)"><?php echo $score1[2] ?></button></td>
                            <td><button id="score_button3_2" class="button_table" disabled onclick="selectResult(3)"><?php echo $score2[2] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">4er</td>
                            <td><button id="score_button4_1" class="button_table" disabled onclick="selectResult(4)"><?php echo $score1[3] ?></button></td>
                            <td><button id="score_button4_2" class="button_table" disabled onclick="selectResult(4)"><?php echo $score2[3] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">5er</td>
                            <td><button id="score_button5_1" class="button_table" disabled onclick="selectResult(5)"><?php echo $score1[4] ?></button></td>
                            <td><button id="score_button5_2" class="button_table" disabled onclick="selectResult(5)"><?php echo $score2[4] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">6er</td>
                            <td><button id="score_button6_1" class="button_table" disabled onclick="selectResult(6)"><?php echo $score1[5] ?></button></td>
                            <td><button id="score_button6_2" class="button_table" disabled onclick="selectResult(6)"><?php echo $score2[5] ?></button></td>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Summe oben</td>
                            <td class="table_cell"><?php echo $score1[6]?></td>
                            <td class="table_cell"><?php echo $score2[6]?></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Bonus (63+)</td>
                            <td class="table_cell"><?php echo $score1[7]?></td>
                            <td class="table_cell"><?php echo $score2[7]?></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Gesamt oben</td>
                            <td class="table_cell"><?php echo $score1[8]?></td>
                            <td class="table_cell"><?php echo $score2[8]?></td>
                        </tr>
                    </thead>
                </table>

                <table>
                    <thead>
                        <tr>
                            <td class="table_cell"></td>
                            <td class="table_cell_heading"><?php echo $player1 ?></td>
                            <td class="table_cell_heading"><?php echo $player2 ?> </td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">3er Pasch</td>
                            <td><button id="score_button7_1" class="button_table" disabled onclick="selectResult(7)"><?php echo $score1[9] ?></button></td>
                            <td><button id="score_button7_2" class="button_table" disabled onclick="selectResult(7)"><?php echo $score2[9] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">4er Pasch</td>
                            <td><button id="score_button8_1" class="button_table" disabled onclick="selectResult(8)"><?php echo $score1[10] ?></button></td>
                            <td><button id="score_button8_2" class="button_table" disabled onclick="selectResult(8)"><?php echo $score2[10] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Full House</td>
                            <td><button id="score_button9_1" class="button_table" disabled onclick="selectResult(9)"><?php echo $score1[11] ?></button></td>
                            <td><button id="score_button9_2" class="button_table" disabled onclick="selectResult(9)"><?php echo $score2[11] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Kleine Straße</td>
                            <td><button id="score_button10_1" class="button_table" disabled onclick="selectResult(10)"><?php echo $score1[12] ?></button></td>
                            <td><button id="score_button10_2" class="button_table" disabled onclick="selectResult(10)"><?php echo $score2[12] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Große Straße</td>
                            <td><button id="score_button11_1" class="button_table" disabled onclick="selectResult(11)"><?php echo $score1[13] ?></button></td>
                            <td><button id="score_button11_2" class="button_table" disabled onclick="selectResult(11)"><?php echo $score2[13] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Kniffel</td>
                            <td><button id="score_button12_1" class="button_table" disabled onclick="selectResult(12)"><?php echo $score1[14] ?></button></td>
                            <td><button id="score_button12_2" class="button_table" disabled onclick="selectResult(12)"><?php echo $score2[14] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Chance</td>
                            <td><button id="score_button13_1" class="button_table" disabled onclick="selectResult(13)"><?php echo $score1[15] ?></button></td>
                            <td><button id="score_button13_2" class="button_table" disabled onclick="selectResult(13)"><?php echo $score2[15] ?></button></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Gesamt unten</td>
                            <td class="table_cell"><?php echo $score1[16]?></td>
                            <td class="table_cell"><?php echo $score2[16]?></td>
                        </tr>
                        <tr class="table_cell">
                            <td class="table_cell_heading">Gesamt</td>
                            <td class="table_cell"><?php echo $score1[17]?></td>
                            <td class="table_cell"><?php echo $score2[17]?></td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="item">
            <button class="standard_button" onclick="endRound()" style="width: 500px">Runde beenden!</button>
        </div>

    </div>

</body>
</html>
