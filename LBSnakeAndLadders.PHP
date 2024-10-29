<?php

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "snake_and_ladders";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert new score (if received from the game)
if (isset($_POST['player_name']) && isset($_POST['score'])) {
    $player_name = mysqli_real_escape_string($conn, $_POST['player_name']);
    $score = mysqli_real_escape_string($conn, $_POST['score']);
    $sql = "INSERT INTO leaderboard (player_name, score) VALUES ('$player_name', $score)";
    if (mysqli_query($conn, $sql)) {
        echo "Score added successfully!";
    } else {
        echo "Error adding score: " . mysqli_error($conn);
    }
}

$sql = "SELECT player_name, score FROM leaderboard ORDER BY score DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Snake & Ladders Leaderboard</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Player Name</th><th>Score</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["player_name"] . "</td>";
        echo "<td>" . $row["score"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No scores yet!";
}

mysqli_close($conn);

?>
