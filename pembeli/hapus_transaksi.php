<?php
session_start();
require "../config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];
$id = $_GET['id'];

// Hanya hapus transaksi milik user yang sedang login
mysqli_query($koneksi, "
    DELETE FROM transaksi 
    WHERE id = '$id' AND user_id = '$user_id'
");

header("Location: riwayat.php");
exit();
