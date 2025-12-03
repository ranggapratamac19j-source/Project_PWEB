<?php include '../config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">
    <h2>Tambah Buku</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Judul Buku</label>
            <input type="text" name="judul">
        </div>

        <div class="form-group">
            <label>Penulis</label>
            <input type="text" name="penulis">
        </div>

        <div class="form-group">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun">
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga">
        </div>

        <div class="form-group">
            <label>Gambar Buku</label>
            <input type="file" name="gambar">
        </div>

        <button name="simpan">SIMPAN</button>
    </form>

    <a class="btn-kembali" href="index.php">Kembali</a>
</div>

<?php
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];

    // Upload gambar
    $namaFile = $_FILES['gambar']['name'];
    $tmpFile = $_FILES['gambar']['tmp_name'];

    $folder = "../uploads/" . $namaFile;

    if (!move_uploaded_file($tmpFile, $folder)) {
        die("Upload gagal! Pastikan folder uploads bisa diakses.<br>");
    }

    // Insert database
    $sql = "INSERT INTO buku (judul, penulis, tahun, harga, gambar)
            VALUES ('$judul', '$penulis', '$tahun', '$harga', '$namaFile')";

    $q = mysqli_query($koneksi, $sql);

    if (!$q) {
        die("SQL Error: " . mysqli_error($koneksi));
    }

    header("Location: index.php");
    exit;
}

?>
</body>
</html>