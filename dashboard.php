<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
    <p><a href="transaksi.php">Input Transaksi Pembelian</a></p>
    <p><a href="saldo.php">Lihat Saldo</a></p>
    <p><a href="laporan.php">Laporan Transaksi</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>

</html>