<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: catalog.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Bread Cake</title>
</head>
<body>
    <h1>Selamat Datang di Bread Cake</h1>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
</body>
</html>
