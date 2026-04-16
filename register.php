<?php
session_start();

$conn = mysqli_connect("localhost", "root", "root", "sportres");
if (!$conn) {
    die("Błąd: " . mysqli_connect_error());
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['login']);
    $mail = trim($_POST['mail']);
    $password = $_POST['pass'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Hasła nie są takie same";
    } else {

        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE username = ? OR mail = ?"
        );
        $stmt->bind_param("ss", $username, $mail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Użytkownik lub email już istnieje";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password_hash, mail, pass) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $hash, $mail, $password);

            if ($stmt->execute()) {
                $success = "Konto utworzone pomyślnie";
            } else {
                $error = "Błąd: " . $stmt->error;
            }
        }
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
    <title>Rejestracja</title>
</head>
<body>

<header>
    <img src="images/sportres-logo.png" alt="logo" class="site_logo">
</header>

<main>
    <div class="login">
        <h2>Rejestracja</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Login:</label><br>
            <input type="text" name="login" required minlength="3"><br><br>

            <label>Email:</label><br>
            <input type="email" name="mail" required><br><br>

            <label>Hasło:</label><br>
            <input type="password" name="pass" required minlength="6"><br><br>

            <label>Powtórz hasło:</label><br>
            <input type="password" name="confirm" required minlength="6"><br><br>

            <button type="submit">Zarejestruj się</button>
        </form>
    </div>
</main>

</body>
</html>