<?php
    $player1 = $_GET['spieler1'];
    $player2 = $_GET['spieler2'];

    $servername = "localhost";
    $username = "root";
    $password = "";


        // Create connection
        $conn = mysqli_connect($servername, $username, $password, "kniffel");

        // delete all entries from tasks
        $sql = 'TRUNCATE TABLE score';
        mysqli_query($conn, $sql);

        // Insert player1 and player2 into score table
        $sql = "INSERT INTO `score`(`playername`) VALUES ('$player1'),('$player2');";
        mysqli_query($conn, $sql);

        // Read the SQL server response
        $response = mysqli_affected_rows($conn);

        // delete all entries from tasks
        $sql = 'TRUNCATE TABLE activeround';
        mysqli_query($conn, $sql);

        // Insert standard values into activeround table
        $sql = "INSERT INTO `activeround`(`dicelocked1`, `dicelocked2`, `dicelocked3`, `dicelocked4`, `dicelocked5`, `rollCounter`, `diceScore1`, `diceScore2`, `diceScore3`, `diceScore4`, `diceScore5`) VALUES ('0','0','0','0','0','0','1','2','3','4','5');";
        mysqli_query($conn, $sql);

        $conn->close();

    
?>
