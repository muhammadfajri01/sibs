<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM transaksi WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
</head>

<body>
    <h2>Laporan Transaksi Anda</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Penjual</th>
            <th>Jenis Sampah</th>
            <th>Harga</th>
            <th>Berat (kg)</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
        <?php while ($transaksi = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $transaksi['id']; ?></td>
                <td><?php echo $transaksi['nama_penjual']; ?></td>
                <td><?php echo $transaksi['jenis_sampah']; ?></td>
                <td>Rp <?php echo number_format($transaksi['harga'], 2, ',', '.'); ?></td>
                <td><?php echo $transaksi['berat']; ?></td>
                <td>Rp <?php echo number_format($transaksi['total'], 2, ',', '.'); ?></td>
                <td><?php echo $transaksi['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</body>

</html>