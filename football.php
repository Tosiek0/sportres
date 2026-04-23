<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

$sql = "
SELECT 
    t1.name AS home_team, 
    t2.name AS away_team, 
    t1.team_logo AS home_logo,
    t2.team_logo AS away_logo,
    l.name AS league_name,
    l.league_logo AS league_logo,
    g.goals_home, 
    g.goals_away 
FROM games g
JOIN teams t1 ON g.id_home = t1.id
JOIN teams t2 ON g.id_away = t2.id
JOIN leauges l ON g.id_league = l.id    
";

$result = $conn->query($sql);
$matches = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $matches[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="images/sportres-logo-bt.png">
    <title>Piłka Nożna</title>
</head>
<body>
    <header>
        <a href="home.html"><img src="images/sportres-logo.png" alt="logo" class="site_logo"></a>
        <img src="images/football.png" alt="footbal_icon" class="icons">
        <a href="football.html" class="sports">Piłka Nożna</a>
        <img src="images/hockey.png" alt="hockey_icon" class="icons">
        <a href="hockey.html" class="sports">Hokej</a>
        <img src="images/basketball.png" alt="basketball_icon" class="icons">
        <a href="basketball.html" class="sports">Koszykówka</a>
        <img src="images/tennis.png" alt="tennis_icon" class="icons">
        <a href="tennis.html" class="sports">Tenis</a>
        <a href="register.php"><button id="logreg">Wyloguj się</button></a>
        <div class="toogles">
            <button onclick="document.body.classList.toggle('big')" class="font">
                <img src="images/font_toogle.png" alt="toogle_font" class="toogle_font">
            </button>
            <button onclick="document.body.classList.toggle('light')" class="mode">
                <img src="images/toogle.png" alt="toogle_mode" class="toogle_mode">
            </button>
        </div>
    </header>

    <main>  
        <?php foreach ($matches as $match): ?>
            <div class="box">  
            <div class="league">
                <img src="data:image/png;base64,<?php echo base64_encode($match['league_logo']); ?>" alt="league_logo" class="league_logo">
                <p><?php echo $match['league_name']; ?></p>
            </div>
            <div class="match">
                <img src="data:image/png;base64,<?php echo base64_encode($match['home_logo']); ?>" alt="home_logo" class="club_logo">
                <p>
                    <?php echo $match['home_team'] . " " . $match['goals_home']; ?> 
                    - 
                    <?php echo $match['goals_away'] . " " . $match['away_team']; ?>
                </p>
                <img src="data:image/png;base64,<?php echo base64_encode($match['away_logo']); ?>" alt="away_logo" class="club_logo">
            </div>
            </div>
        <?php endforeach; ?>
    </main> 
</body>
</html>