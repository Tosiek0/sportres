<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['login']);
    $password = $_POST['pass'];

    $stmt = $conn->prepare(
        "SELECT id, username, pass FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {

        if ($password == $user['pass']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.html");
            exit;
        }
    }

    $error = "Zły login lub hasło";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_login.css">
    <link rel="icon" type="image/x-icon" href="images/sportres-logo-bt.png">
    <title>Logowanie</title>
</head>
<body>
<header>
    <img src="images/sportres-logo.png" alt="logo" class="site_logo">
</header>

<main>
    <div class="login">
        <h2>Logowanie</h2>
        <form method="POST">
            <label>Login:</label><br>
            <input type="text" name="login" required><br><br>

            <label>Hasło:</label><br>
            <input type="password" name="pass" required><br><br>

            <button type="submit">Zaloguj się</button>
        </form>
    </div>
</main>
</body>
</html>