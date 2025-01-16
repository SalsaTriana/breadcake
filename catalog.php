<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Katalog Produk</title>
</head>
<body>
    <h1>Katalog Produk</h1>
    <a href="logout.php">Logout</a>
    <br><br>
    <?php
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "' width='100'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<p>Harga: Rp. " . $row['price'] . "</p>";
        echo "<a href='add_to_cart.php?id=" . $row['id'] . "'>Tambah ke Keranjang</a>";
        echo "</div><hr>";
    }
    ?>
</body>
</html>
