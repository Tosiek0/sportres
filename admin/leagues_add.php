<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $league_name = $_POST['league_name'];
    $image = $_FILES['league_logo']['tmp_name'];

    if (!empty($image)) {
        $imgContent = addslashes(file_get_contents($image));

        $sql = "INSERT INTO leauges (name, league_logo) VALUES ('$league_name', '$imgContent')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Dodano ligę";
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    } else {
        echo "Wybierz obraz";
    }
}
?>