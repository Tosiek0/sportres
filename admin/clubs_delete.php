<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['club_id']) && !empty($_POST['club_id'])) {

        $club_id = $_POST['club_id'];

        $sql = "DELETE FROM teams WHERE id = $club_id";

        if (mysqli_query($conn, $sql)) {
            if (mysqli_affected_rows($conn) > 0) {
                echo "Usunięto klub";
            } else {
                echo "Nie znaleziono klubu o podanym ID";
            }
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }

    } else {
        echo "Podaj ID klubu";
    }
}
?>