<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_home    = $_POST['id_home'];
    $id_away    = $_POST['id_away'];
    $id_league  = $_POST['id_league'];
    $goals_home = $_POST['goals_home'];
    $goals_away = $_POST['goals_away'];
    $date       = $_POST['date'];

    $sql = "INSERT INTO games (id_home, id_away, id_league, goals_home, goals_away, date) 
            VALUES ('$id_home', '$id_away', '$id_league', '$goals_home', '$goals_away', '$date')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Dodano mecz</p>";
    } else {
        echo "Błąd: " . mysqli_error($conn);;
    }
}
?>