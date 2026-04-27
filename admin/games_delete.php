<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['game_id']) && !empty($_POST['game_id'])) {

        $game_id = $_POST['game_id'];

        $sql = "DELETE FROM games WHERE id = $game_id";

        if (mysqli_query($conn, $sql)) {
            if (mysqli_affected_rows($conn) > 0) {
                echo "Usunięto mecz";
            } else {
                echo "Nie znaleziono meczu o podanym ID";
            }
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }

    } else {
        echo "Podaj ID meczu!";
    }
}
?>