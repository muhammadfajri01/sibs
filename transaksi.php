<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama_penjual = $_POST['nama_penjual'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $harga = ($jenis_sampah == 'plastik') ? 1000 : 2000;
    $berat = $_POST['berat'];
    $total = $harga * $berat;

    $sql = "INSERT INTO transaksi (user_id, nama_penjual, jenis_sampah, harga, berat, total) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issddd", $user_id, $nama_penjual, $jenis_sampah, $harga, $berat, $total);

    if ($stmt->execute()) {
        // Update saldo user
        $update_sql = "UPDATE users SET saldo = saldo + ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("di", $total, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
        echo "Transaksi berhasil!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Input Transaksi</title>
</head>

<body>
    <h2>Input Transaksi Pembelian</h2>
    <form method="post" action="">
        <label>Nama Penjual:</label><br>
        <input type="text" name="nama_penjual" required><br>
        <label>Jenis Sampah:</label><br>
        <select name="jenis_sampah" required>
            <option value="plastik">Plastik</option>
            <option value="kertas">Kertas</option>
        </select><br>
        <label>Berat (kg):</label><br>
        <input type="number" name="berat" step="0.01" required><br><br>
        <input type="submit" value="Input Transaksi">
    </form>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</body>

</html>