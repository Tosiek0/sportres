<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['league_id']) && !empty($_POST['league_id'])) {

        $league_id = $_POST['league_id'];

        $sql = "DELETE FROM leauges WHERE id = $league_id";

        if (mysqli_query($conn, $sql)) {
            if (mysqli_affected_rows($conn) > 0) {
                echo "Usunięto ligę";
            } else {
                echo "Nie znaleziono ligi o podanym ID";
            }
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }

    } else {
        echo "Podaj ID ligi";
    }
}
?>