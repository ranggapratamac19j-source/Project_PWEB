<?php 
include '../config.php';
$data = mysqli_query($koneksi, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    
<header class="header">
    <h1>Toko Buku</h1>
</header>

<h2>Daftar Buku</h2>
<a href="tambah.php" class="btn-tambah">+ Tambah Buku</a>

<div class="container">

<?php while ($b = mysqli_fetch_assoc($data)) { ?>
    <div class="card">
        <?php
        $gambar = $b['gambar'] ? "../uploads/" . $b['gambar'] : "https://via.placeholder.com/300x200?text=No+Image";
        ?>
        <img src="<?= $gambar ?>" class="book-image">

        <div class="title"><?= $b['judul'] ?></div>
        <div class="penulis">By <?= $b['penulis'] ?></div>
        <div class="harga">Rp <?= number_format($b['harga']) ?></div>

        <a class="btn edit" href="edit.php?id=<?= $b['id'] ?>">Edit</a>
        <a class="btn hapus" href="hapus.php?id=<?= $b['id'] ?>" onclick="return confirm('Hapus buku ini?')">Hapus</a>
    </div>
<?php } ?>

</div>

</body>
</html>
