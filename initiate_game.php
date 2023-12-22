<?php
    $player1 = $_POST['spieler1'];
    $player2 = $_POST['spieler2'];

    $servername = "localhost";
    $username = "root";
    $password = "";

    if (!$player1 || !$player2) {
        header("Location: index.php");
        exit;
    }
    else if ($player1 == $player2) {
        header("Location: index.php");
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

        // Read the SQL server response
        $response = mysqli_affected_rows($conn);

        if ($response == 2) {
            header("Location: game.php");
            exit;
        }
        else {
            header("Location: index.php");
            exit;
        }

        $conn->close();
    }
?>
