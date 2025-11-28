<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
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

    // upload gambar
    $namaFile = $_FILES['gambar']['name'];
    $tmpFile = $_FILES['gambar']['tmp_name'];

    $folder = "uploads/" . $namaFile;

    move_uploaded_file($tmpFile, $folder);

    mysqli_query($koneksi, "INSERT INTO buku VALUES 
        (NULL, '$judul', '$penulis', '$tahun', '$harga', '$namaFile')");

    header("Location: index.php");
}

?>
</body>
</html>
