<?php

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, "kniffel");

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if($data['type'] == "diceLocked"){

        // ##### Get All activeRound Values #####
        $sql = "SELECT * FROM `activeround` WHERE 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Get dicelocked values
        $dicelocked = array(
            0 => (int)$row['dicelocked1'],
            1 => (int)$row['dicelocked2'],
            2 => (int)$row['dicelocked3'],
            3 => (int)$row['dicelocked4'],
            4 => (int)$row['dicelocked5'],
        );

        $dicelocked[$data['buttonId'] - 1] = $dicelocked[$data['buttonId'] - 1] == 0 ? 1 : 0;

        // ##### Update activeRound Values #####
        $sql = "UPDATE `activeround` SET `dicelocked1`=$dicelocked[0],`dicelocked2`=$dicelocked[1],`dicelocked3`=$dicelocked[2],`dicelocked4`=$dicelocked[3],`dicelocked5`=$dicelocked[4] WHERE 1";
        $result = mysqli_query($conn, $sql);

        // Create new dice.json file
        $dice = array(
            0 => array(
                'id' => 1,
                'value' => (int)$row['diceScore1'],
                'locked' => $dicelocked[0]
            ),
            1 => array(
                'id' => 2,
                'value' => (int)$row['diceScore2'],
                'locked' => $dicelocked[1]
            ),
            2 => array(
                'id' => 3,
                'value' => (int)$row['diceScore3'],
                'locked' => $dicelocked[2]
            ),
            3 => array(
                'id' => 4,
                'value' => (int)$row['diceScore4'],
                'locked' => $dicelocked[3]
            ),
            4 => array(
                'id' => 5,
                'value' => (int)$row['diceScore5'],
                'locked' => $dicelocked[4]
            ),
        );

        $diceJson = array(
            'dice' => $dice,
            'rollCounter' => (int)$row['rollCounter'],
        );

        // sending json back to client
        echo json_encode($diceJson);

        $conn->close();
    }

    elseif ($data['type'] == "rollDices") {

        // ##### Get All activeRound Values #####
        $sql = "SELECT * FROM `activeround` WHERE 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Get dicelocked values
        $dicelocked = array(
            0 => (int)$row['dicelocked1'],
            1 => (int)$row['dicelocked2'],
            2 => (int)$row['dicelocked3'],
            3 => (int)$row['dicelocked4'],
            4 => (int)$row['dicelocked5'],
        );
        // Roll all enabled dices
        $dice = array(
            0 => $dicelocked[0] == 0 ? rand(1,6) : (int)$row['diceScore1'],
            1 => $dicelocked[1] == 0 ? rand(1,6) : (int)$row['diceScore2'],
            2 => $dicelocked[2] == 0 ? rand(1,6) : (int)$row['diceScore3'],
            3 => $dicelocked[3] == 0 ? rand(1,6) : (int)$row['diceScore4'],
            4 => $dicelocked[4] == 0 ? rand(1,6) : (int)$row['diceScore5'],
        );


        $rollCounter = (int)$row['rollCounter'] + 1;

        // ##### Update activeRound Values #####
        $sql = "UPDATE `activeround` SET `rollCounter`= {$rollCounter},`diceScore1`={$dice[0]},`diceScore2`={$dice[1]},`diceScore3`={$dice[2]},`diceScore4`={$dice[3]},`diceScore5`={$dice[4]} WHERE 1";
        $result = mysqli_query($conn, $sql);

        $conn->close();

        sendAllValues();
    }

    elseif ($data['type'] == "selectResult") {

        // ##### Get all dice values #####
        $sql = "SELECT * FROM `activeround` WHERE 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $diceValues = array(
            0 => (int)$row['diceScore1'],
            1 => (int)$row['diceScore2'],
            2 => (int)$row['diceScore3'],
            3 => (int)$row['diceScore4'],
            4 => (int)$row['diceScore5'],
        );

        // Get all score values from active player
        $sql = "SELECT * FROM `score` ORDER BY `score`.`id` DESC LIMIT 1, 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $scoreValues = array(
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

        $validMove = false;
        $field = "";

        // ##### Check if result is valid #####
        // 1er - 6er
        if($data['id'] >= 1 && $data['id'] <= 6){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkNumberSum($diceValues, $data['id']);
                $validMove = true;
                $field = $data['id'] . "er";
            }
            else {
                $validMove = false;
            }
        }

        // 3er Pasch
        if($data['id'] == 10){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkPasch($diceValues, 3) ? checkNumberSumAll($diceValues) : 0;
                $validMove = true;
                $field = "3er_pasch";
            }
            else {
                $validMove = false;
            }
        }

        // 4er Pasch
        if($data['id'] == 11){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkPasch($diceValues, 4) ? checkNumberSumAll($diceValues) : 0;
                $validMove = true;
                $field = "4er_pasch";
            }
            else {
                $validMove = false;
            }
        }

        // Full House
        if($data['id'] == 12){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkFullHouse($diceValues) ? 25 : 0;
                $validMove = true;
                $field = "full_house";
            }
            else {
                $validMove = false;
            }
        }

        // Kleine Straße
        if($data['id'] == 13){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkKleineStrasse($diceValues) ? 30 : 0;
                $validMove = true;
                $field = "kleine_strasse";
            }
            else {
                $validMove = false;
            }
        }

        // Große Straße
        if($data['id'] == 14){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkGrosseStrasse($diceValues) ? 40 : 0;
                $validMove = true;
                $field = "grosse_strasse";
            }
            else {
                $validMove = false;
            }
        }

        // Kniffel
        if($data['id'] == 15){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkKniffel($diceValues) ? 50 : 0;
                $validMove = true;
                $field = "kniffel";
            }
            else {
                $validMove = false;
            }
        }

        // Chance
        if($data['id'] == 16){
            if($scoreValues[$data['id'] - 1] == NULL){
                $scoreValues[$data['id'] - 1] = checkChance($diceValues);
                $validMove = true;
                $field = "chance";
            }
            else {
                $validMove = false;
            }
        }

        // ##### Calculate total scores #####
        $scoreValues[6] = 0;
        for ($i = 0; $i < 6; $i++) {
            $scoreValues[6] += $scoreValues[$i];
        }

        if ($scoreValues[6] >= 63) {
            $scoreValues[7] = 35;
        }

        $scoreValues[8] = $scoreValues[6] + $scoreValues[7];

        $scoreValues[16] = 0;
        for ($i = 9; $i < 16; $i++) {
            $scoreValues[16] += $scoreValues[$i];
        }

        $scoreValues[17] = $scoreValues[8] + $scoreValues[16];

        // ##### Update score table #####
        if($validMove){

            // duplicate second last entry for active player
            $sql = "INSERT INTO `score` (`playername`, `1er`, `2er`, `3er`, `4er`, `5er`, `6er`, `summe_oben`, `bonus`, `gesamt_oben`, `3er_pasch`, `4er_pasch`, `full_house`, `kleine_strasse`, `grosse_strasse`, `kniffel`, `chance`, `gesamt_unten`, `gesamt`) SELECT `playername`, `1er`, `2er`, `3er`, `4er`, `5er`, `6er`, `summe_oben`, `bonus`, `gesamt_oben`, `3er_pasch`, `4er_pasch`, `full_house`, `kleine_strasse`, `grosse_strasse`, `kniffel`, `chance`, `gesamt_unten`, `gesamt` FROM `score` ORDER BY `score`.`id` DESC LIMIT 1, 1";
            $result = mysqli_query($conn, $sql);

            // update last entry with new score
            $sql = "UPDATE `score` SET `$field`={$scoreValues[$data['id'] - 1]},`summe_oben`={$scoreValues[6]},`bonus`={$scoreValues[7]},`gesamt_oben`={$scoreValues[8]},`gesamt_unten`={$scoreValues[16]},`gesamt`={$scoreValues[17]} ORDER BY `score`.`id` DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);


            // delete all entries from table
            $sql = 'TRUNCATE TABLE activeround';
            mysqli_query($conn, $sql);

            // Insert standard values into activeround table
            $sql = "INSERT INTO `activeround`(`dicelocked1`, `dicelocked2`, `dicelocked3`, `dicelocked4`, `dicelocked5`, `rollCounter`, `diceScore1`, `diceScore2`, `diceScore3`, `diceScore4`, `diceScore5`) VALUES ('0','0','0','0','0','0','1','2','3','4','5');";
            mysqli_query($conn, $sql);

            $conn->close();
        }

        sendAllValues();

    }

    elseif($data['type'] == "sendGameState"){
        sendAllValues();
    }

    function sendAllValues(){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $conn = mysqli_connect($servername, $username, $password, "kniffel");


        // Get Players
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

        if($activePlayer == $player1){
            $activePlayerNum = 0;
        }
        else {
            $activePlayerNum = 1;
        }

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

        // get activeRound values
        $sql = "SELECT * FROM `activeround` WHERE 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $rollCounter = (int)$row['rollCounter'];

        // Create json scoreList
        $scoreList = array(
            0 => createScoreObject(1, "1er", $activePlayerNum, $score1[0], $score2[0], $rollCounter),
            1 => createScoreObject(2, "2er", $activePlayerNum, $score1[1], $score2[1], $rollCounter),
            2 => createScoreObject(3, "3er", $activePlayerNum, $score1[2], $score2[2], $rollCounter),
            3 => createScoreObject(4, "4er", $activePlayerNum, $score1[3], $score2[3], $rollCounter),
            4 => createScoreObject(5, "5er", $activePlayerNum, $score1[4], $score2[4], $rollCounter),
            5 => createScoreObject(6, "6er", $activePlayerNum, $score1[5], $score2[5], $rollCounter),
            6 => createScoreObject(7, "Summe Oben", $activePlayerNum, $score1[6], $score2[6], $rollCounter),
            7 => createScoreObject(8, "Bonus (63+)", $activePlayerNum, $score1[7], $score2[7], $rollCounter),
            8 => createScoreObject(9, "Gesamt Oben", $activePlayerNum, $score1[8], $score2[8], $rollCounter),
            9 => createScoreObject(10, "3er Pasch", $activePlayerNum, $score1[9], $score2[9], $rollCounter),
            10 => createScoreObject(11, "4er Pasch", $activePlayerNum, $score1[10], $score2[10], $rollCounter),
            11 => createScoreObject(12, "Full House", $activePlayerNum, $score1[11], $score2[11], $rollCounter),
            12 => createScoreObject(13, "Kleine Straße", $activePlayerNum, $score1[12], $score2[12], $rollCounter),
            13 => createScoreObject(14, "Große Straße", $activePlayerNum, $score1[13], $score2[13], $rollCounter),
            14 => createScoreObject(15, "Kniffel", $activePlayerNum, $score1[14], $score2[14], $rollCounter),
            15 => createScoreObject(16, "Chance", $activePlayerNum, $score1[15], $score2[15], $rollCounter),
            16 => createScoreObject(17, "Gesamt Unten", $activePlayerNum, $score1[16], $score2[16], $rollCounter),
            17 => createScoreObject(18, "Gesamt", $activePlayerNum, $score1[17], $score2[17], $rollCounter),
        );

        $dice = array(
            0 => array(
                'id' => 1,
                'value' => (int)$row['diceScore1'],
                'locked' => (bool)$row['dicelocked1']
            ),
            1 => array(
                'id' => 2,
                'value' => (int)$row['diceScore2'],
                'locked' => (bool)$row['dicelocked2']
            ),
            2 => array(
                'id' => 3,
                'value' => (int)$row['diceScore3'],
                'locked' => (bool)$row['dicelocked3']
            ),
            3 => array(
                'id' => 4,
                'value' => (int)$row['diceScore4'],
                'locked' => (bool)$row['dicelocked4']
            ),
            4 => array(
                'id' => 5,
                'value' => (int)$row['diceScore5'],
                'locked' => (bool)$row['dicelocked5']
            ),
        );

        $sendingJson = array(
            'dice' => $dice,
            'scoreList' => $scoreList,
            'rollCounter' => $rollCounter,
            'activePlayer' => $activePlayerNum,
            'player_name_1' => $player1,
            'player_name_2' => $player2,
        );

        $conn->close();

        echo json_encode($sendingJson);

    }

    function createScoreObject($id, $name, $activePlayer, $score1, $score2, $scoreCounter){

        if($scoreCounter > 0) {
            $scoreObject = array(
                'id' => $id,
                'name' => $name,
                'value' => array(
                    0 => $score1 == NULL ? 0 : (int)$score1,
                    1 => $score2 == NULL ? 0 : (int)$score2,
                ),
                'locked' => array(
                    0 => $score1 == NULL ? (bool)$activePlayer : true,
                    1 => $score2 == NULL ? !(bool)$activePlayer : true,
                ),
                'possible' => array(
                    0 => false,
                    1 => false,
                ),
            );
        }
        else{
            $scoreObject = array(
                'id' => $id,
                'name' => $name,
                'value' => array(
                    0 => $score1 == NULL ? 0 : (int)$score1,
                    1 => $score2 == NULL ? 0 : (int)$score2,
                ),
                'locked' => array(
                    0 => true,
                    1 => true,
                ),
                'possible' => array(
                    0 => false,
                    1 => false,
                ),
            );
        }

        return $scoreObject;
    }

    function checkNumberFrequency($diceValues, $number){
        $frequency = 0;
        foreach ($diceValues as $diceValue) {
            if ($diceValue == $number) {
                $frequency++;
            }
        }
        return $frequency;
    }

    function checkNumberSum($diceValues, $number){
        $sum = 0;
        foreach ($diceValues as $diceValue) {
            if ($diceValue == $number) {
                $sum += $diceValue;
            }
        }
        return $sum;
    }

    function checkNumberSumAll($diceValues){
        $sum = 0;
        foreach ($diceValues as $diceValue) {
            $sum += $diceValue;
        }
        return $sum;
    }

    function checkPasch($diceValues, $pasch){
        for ($i = 6; $i > 0; $i--) {
            if (checkNumberFrequency($diceValues, $i) >= $pasch) {
                return true;
            }
        }
        return false;
    }

    function checkFullHouse($diceValues){
        $three = false;
        $two = false;
        for ($i = 6; $i > 0; $i--) {
            if (checkNumberFrequency($diceValues, $i) == 3) {
                $three = true;
            }
            if (checkNumberFrequency($diceValues, $i) == 2) {
                $two = true;
            }
        }
        if ($three && $two) {
            return true;
        }
        return false;
    }

    function checkKleineStrasse($diceValues){
        $isStrasse = true;
        $strassen = array(
            0 => array(1,2,3,4),
            1 => array(2,3,4,5),
            2 => array(3,4,5,6),
        );
        foreach ($strassen as $strasse) {
            $isStrasse = true;
            foreach ($strasse as $number) {
                if (!in_array($number, $diceValues)) {
                    $isStrasse = false;
                }
            }
            if ($isStrasse) {
                return true;
            }
        }
        return false;
    }

    function checkGrosseStrasse($diceValues){
        $isStrasse = false;
        $strassen = array(
            0 => array(1,2,3,4,5),
            1 => array(2,3,4,5,6),
        );
        foreach ($strassen as $strasse) {
            $isStrasse = true;
            foreach ($strasse as $number) {
                if (!in_array($number, $diceValues)) {
                    $isStrasse = false;
                }
            }
            if ($isStrasse) {
                return true;
            }
        }
        return false;
    }

    function checkKniffel($diceValues){
        for ($i = 6; $i > 0; $i--) {
            if (checkNumberFrequency($diceValues, $i) == 5) {
                return true;
            }
        }
        return false;
    }

    function checkChance($diceValues){
        return checkNumberSumAll($diceValues);
    }
?>
