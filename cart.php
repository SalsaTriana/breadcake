<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $total_price = $_POST['total_price'];
    $order_date = date('Y-m-d H:i:s');
    $status = 'pending';

    $query = "INSERT INTO orders (user_id, total_price, order_date, status) VALUES ('$user_id', '$total_price', '$order_date', '$status')";
    if (mysqli_query($conn, $query)) {
        $order_id = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $query = "INSERT INTO orderdetails (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
            mysqli_query($conn, $query);
        }

        unset($_SESSION['cart']);
        echo "Pesanan berhasil dibuat!";
    } else {
        echo "Gagal membuat pesanan!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>
    <form method="post" action="">
        <table>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
            <?php
            $total_price = 0;
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $query = "SELECT * FROM products WHERE id='$product_id'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $total = $row['price'] * $quantity;
                $total_price += $total;
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $quantity . "</td>";
                echo "<td>Rp. " . $row['price'] . "</td>";
                echo "<td>Rp. " . $total . "</td>";
                echo "</tr>";
            }
            ?>
            <tr>
                <td colspan="3">Total Harga</td>
                <td>Rp. <?php echo $total_price; ?></td>
            </tr>
        </table>
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <input type="submit" name="checkout" value="Checkout">
    </form>
</body>
</html>
