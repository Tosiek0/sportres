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
        "SELECT id, username, password_hash FROM users WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {

        if (password_verify($password, $user['password_hash'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: home.html");
            exit;
        } else {
            $error = "Nieprawidłowe hasło";
        }

    } else {
        $error = "Użytkownik nie istnieje";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_log_reg.css">
    <link rel="icon" type="image/x-icon" href="images/sportres-logo-bt.png">
    <title>Logowanie</title>
</head>
<body>

<header>
    <a href=login.php><img src="images/sportres-logo.png" alt="logo" class="site_logo"></a>
    <a href=register.php><button id="logreg">Zarejestruj się</button></a>
</header>

<main>
    <div class="login_register">
        <h2>Logowanie</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Login:</label><br>
            <input type="text" name="login" required minlength="3"><br><br>

            <label>Hasło:</label><br>
            <input type="password" name="pass" required minlength="6"><br><br>

            <button type="submit">Zaloguj się</button>
        </form>
    </div>
</main>

</body>
</html>