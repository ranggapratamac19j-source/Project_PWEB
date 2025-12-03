<?php 
include '../config.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE id=$id");
$b = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Buku</h2>

    <form action="" method="POST" enctype="multipart/form-data">    

        <div class="form-group">
            <label>Judul Buku</label>
            <input type="text" name="judul" value="<?= $b['judul'] ?>">
        </div>

        <div class="form-group">
            <label>Penulis</label>
            <input type="text" name="penulis" value="<?= $b['penulis'] ?>">
        </div>

        <div class="form-group">
            <label>Tahun</label>
            <input type="number" name="tahun" value="<?= $b['tahun'] ?>">
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $b['harga'] ?>">
        </div>

        <div class="form-group">
            <label>Gambar Buku (Opsional)</label>
            <input type="file" name="gambar">
        </div>

        <button name="update">UPDATE</button>
    </form>

    <a class="btn-kembali" href="index.php">Kembali</a>
</div>

<?php
if (isset($_POST['update'])) {

    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];

    $namaBaru = $_FILES['gambar']['name'];

    if ($namaBaru != "") {
        // jika ada gambar baru
        $tmpFile = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmpFile, "../uploads/" . $namaBaru);

        $gambarUpdate = ", gambar='$namaBaru'";
    } else {
        $gambarUpdate = "";
    }

    mysqli_query($koneksi, "
        UPDATE buku SET
        judul='$judul',
        penulis='$penulis',
        tahun='$tahun',
        harga='$harga'
        $gambarUpdate
        WHERE id=$id
    ");

    header("Location: index.php");
}

?>
</body>
</html>
