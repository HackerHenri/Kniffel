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

    $sql = "INSERT INTO `score` (`playername`, `$field`, `summe_oben`, `bonus`, `gesamt_oben`, `gesamt_unten`, `gesamt`) VALUES ('$playerName', $scoreGet, $sumTop, $bonus, $totalTop, $sumBottom, $sumTotal)";
    echo $sql;
    $result = mysqli_query($conn, $sql);

?>