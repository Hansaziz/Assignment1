<?php
session_start();

require 'config.php';
require 'functions.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['register'])) {
    handleRegistration();
} elseif (isset($_POST['login'])) {
    handleLogin();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener - Login/Register</title>
</head>
<body>
    <h1>Register and Login</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" name="login">Login</button>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>
