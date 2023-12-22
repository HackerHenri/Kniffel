<?php
    $player1 = $_POST['spieler1'];
    $player2 = $_POST['spieler2'];

    $servername = "localhost";
    $username = "root";
    $password = "";

    if (!$player1 || !$player2) {
        echo "Bitte geben Sie zwei Spielernamen ein!";
        exit;
    }
    else if ($player1 == $player2) {
        echo "Bitte geben Sie zwei unterschiedliche Spielernamen ein!";
        exit;
    }
    else {
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, "kniffel");

        // delete all entries from tasks
        $sql = 'TRUNCATE TABLE score';
        mysqli_query($conn, $sql);

    // Insert player1 and player2 into score table
    $sql = "INSERT INTO `score`(`playername`) VALUES ('$player1'),('$player2');";
    mysqli_query($conn, $sql);

    $conn->close();
    }
?>
