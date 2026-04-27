<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $club_name = $_POST['club_name'];
    $league_id = $_POST['league_id'];
    $image = $_FILES['club_logo']['tmp_name'];

    if (!empty($image)) {
        $imgContent = addslashes(file_get_contents($image));

        $sql = "INSERT INTO teams (name, league_id, team_logo) VALUES ('$club_name', '$league_id', '$imgContent')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Dodano klub";
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    } else {
        echo "Wybierz obraz";
    }
}
?>