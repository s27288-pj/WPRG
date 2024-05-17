<?php
session_start();

$users = [
    'User' => 'test123',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username] == $password) {
        $_SESSION['loggedin'] = true;
        setcookie('username', $username, time() + (86400 * 30), "/");
        header("Location: reservation.php");
        exit;
    } else {
        $error = "Niepoprawna nazwa użytkownika lub hasło!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <h1>Logowanie</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>">
        <br>
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Zaloguj się">
    </form>
</body>
</html>
