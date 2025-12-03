<?php
session_start();
require "../config.php";

// Cek login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];

$riwayat = mysqli_query($koneksi, "
    SELECT transaksi.*, buku.judul, buku.harga, buku.gambar
    FROM transaksi
    LEFT JOIN buku ON transaksi.buku_id = buku.id
    WHERE transaksi.user_id = '$user_id'
    ORDER BY transaksi.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembelian</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<h2>Riwayat Pembelian</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Gambar</th>
        <th>Judul Buku</th>
        <th>Harga</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    <?php 
    $total = 0;
    while($row = mysqli_fetch_assoc($riwayat)):
        $total += $row['harga'];
    ?>
    <tr>
        <td><img src="../uploads/<?php echo $row['gambar']; ?>" width="80"></td>
        <td><?php echo $row['judul']; ?></td>
        <td>Rp<?php echo number_format($row['harga']); ?></td>
        <td><?php echo $row['tanggal']; ?></td>

        <td>
            <a 
                href="hapus_transaksi.php?id=<?php echo $row['id']; ?>" 
                class="btn-logout"
                onclick="return confirm('Hapus transaksi ini?')"
            >
                Delete
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<div class="total-row">
    <span>Total Pembelian:</span>
    <span class="total-angka">Rp <?php echo number_format($total); ?></span>
</div>

<div class="right-box">
    <a href="index.php" class="btn-back-glass">Kembali ke Menu Pembeli</a>
</div>

</body>
</html>
