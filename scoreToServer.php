<?php
    $scoreGet = $_GET['score'];
    $fieldGet = $_GET['field'];
    switch ($fieldGet){
        case 0:
            $field = "1er";
            break;
        case 1:
            $field = "2er";
            break;
        case 2:
            $field = "3er";
            break;
        case 3:
            $field = "4er";
            break;
        case 4:
            $field = "5er";
            break;
        case 5:
            $field = "6er";
            break;
        case 6:
            $field = "3er_pasch";
            break;
        case 7:
            $field = "4er_pasch";
            break;
        case 8:
            $field = "full_house";
            break;
        case 9:
            $field = "kleine_strasse";
            break;
        case 10:
            $field = "grosse_strasse";
            break;
        case 11:
            $field = "kniffel";
            break;
        case 12:
            $field = "chance";
            break;
    }
    $playerName = $_GET['player'];
    $sumTop = $_GET['sumTop'];
    $sumBottom = $_GET['sumBottom'];
    $sumTotal = $_GET['sum'];
    $bonus = $_GET['bonus'];
    $totalTop = $_GET['totalTop'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, "kniffel");

    // get last entry for incremente id
//    $sql = "SELECT * FROM `score` ORDER BY `score`.`id` DESC LIMIT 1";
//    $result = mysqli_query($conn, $sql);
//    $row = mysqli_fetch_assoc($result);
//    $id = $row['id'];
//    $id++;

    // duplicate second last entry for active player
    $sql = "INSERT INTO `score` (`playername`, `1er`, `2er`, `3er`, `4er`, `5er`, `6er`, `summe_oben`, `bonus`, `gesamt_oben`, `3er_pasch`, `4er_pasch`, `full_house`, `kleine_strasse`, `grosse_strasse`, `kniffel`, `chance`, `gesamt_unten`, `gesamt`) SELECT `playername`, `1er`, `2er`, `3er`, `4er`, `5er`, `6er`, `summe_oben`, `bonus`, `gesamt_oben`, `3er_pasch`, `4er_pasch`, `full_house`, `kleine_strasse`, `grosse_strasse`, `kniffel`, `chance`, `gesamt_unten`, `gesamt` FROM `score` ORDER BY `score`.`id` DESC LIMIT 1, 1";
    $result = mysqli_query($conn, $sql);

    // update last entry with new score
    $sql = "UPDATE `score` SET `$field` = '$scoreGet', `summe_oben` = '$sumTop', `gesamt_oben` = '$totalTop', `gesamt_unten` = '$sumBottom', `gesamt` = '$sumTotal', `bonus` = '$bonus' ORDER BY `score`.`id` DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    // delete all entries from table
    $sql = 'TRUNCATE TABLE activeround';
    mysqli_query($conn, $sql);

    // Insert standard values into activeround table
    $sql = "INSERT INTO `activeround`(`dicelocked1`, `dicelocked2`, `dicelocked3`, `dicelocked4`, `dicelocked5`, `rollCounter`, `diceScore1`, `diceScore2`, `diceScore3`, `diceScore4`, `diceScore5`) VALUES ('0','0','0','0','0','0','1','2','3','4','5');";
    mysqli_query($conn, $sql);


    $conn->close();
?>