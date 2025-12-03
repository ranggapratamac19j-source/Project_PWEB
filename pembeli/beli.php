<?php
session_start();
require "../config.php";

// Cek login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];
$buku_id = $_GET['id'];

// Cek apakah buku ada
$cek = mysqli_query($koneksi, "SELECT * FROM buku WHERE id='$buku_id'");
if (mysqli_num_rows($cek) == 0) {
    die("Buku tidak ditemukan.");
}

// Insert transaksi
mysqli_query($koneksi, "INSERT INTO transaksi (user_id, buku_id) VALUES ('$user_id', '$buku_id')");

echo "<script>alert('Pembelian berhasil!'); window.location='riwayat.php';</script>";
