<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT saldo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lihat Saldo</title>
</head>

<body>
    <h2>Saldo Anda</h2>
    <p>Saldo: Rp <?php echo number_format($user['saldo'], 2, ',', '.'); ?></p>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</body>

</html>