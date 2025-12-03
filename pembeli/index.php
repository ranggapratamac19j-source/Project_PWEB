<?php
session_start();
require "../config.php";

// Cek login & role pembeli
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
    header("Location: ../login.php");
    exit();
}

$buku = mysqli_query($koneksi, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Pembeli</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header class="header">
    <h1><a href="index.php" class="header-title">Toko Buku</a></h1>
</header>

<div class="navbar">
    <span class="nav-title">Daftar Buku</span>

    <div class="nav-right">
        <a href="riwayat.php" class="nav-btn">Riwayat Pembelian</a>
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="search-books-container">
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari buku..." />
        <button id="searchBtn">Cari Buku</button>
    </div>
</div>

<div id="bookResults" class="container" style="display: none;"></div>

<div id="defaultBooks" class="container">
<?php while ($b = mysqli_fetch_assoc($buku)) { ?>
    <div class="card">
        <?php
        $gambar = $b['gambar'] ? "../uploads/" . $b['gambar'] : "https://via.placeholder.com/300x200?text=No+Image";
        ?>
        <img src="<?= $gambar ?>" class="book-image" alt="<?= $b['judul'] ?>">

        <div class="title"><?= $b['judul'] ?></div>
        <div class="penulis">By <?= $b['penulis'] ?></div>
        <div class="harga">Rp <?= number_format($b['harga']) ?></div>

        <a href="beli.php?id=<?php echo $b['id']; ?>" class="button">Beli</a>
    </div>
<?php } ?>
</div>

</body>
</html>

<script>
document.getElementById("searchBtn").addEventListener("click", () => {
    const query = document.getElementById("searchInput").value;
    const bookResults = document.getElementById("bookResults");
    const defaultBooks = document.getElementById("defaultBooks");

    if (!query.trim()) {
        // Jika input kosong, tampilkan buku default
        bookResults.style.display = "none";
        defaultBooks.style.display = "grid";
        return;
    }

    fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=20`)
        .then(res => res.json())
        .then(data => {
            // Sembunyikan buku default
            defaultBooks.style.display = "none";
            
            // Tampilkan hasil pencarian
            bookResults.style.display = "grid";
            bookResults.innerHTML = ""; // clear

            if (!data.items || data.items.length === 0) {
                bookResults.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;"><p>Tidak ada buku ditemukan untuk "' + query + '"</p></div>';
                return;
            }

            data.items.forEach(book => {
                const info = book.volumeInfo;
                
                const cover = info.imageLinks?.thumbnail || 
                    "https://via.placeholder.com/128x192?text=No+Cover";
                
                const harga = Math.floor(Math.random() * (300000 - 50000 + 1)) + 50000;
                
                // Fungsi untuk truncate text
                const truncateText = (text, maxLength = 25) => {
                    if (!text) return "Tidak Tersedia";
                    return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
                };
                
                const judul = truncateText(info.title, 25);
                const penulis = truncateText(info.authors?.join(", "), 25);

                const card = `
                    <div class="card">
                        <img src="${cover}" alt="${info.title}" class="book-image">
                        <div class="title">${judul}</div>
                        <div class="penulis">By ${penulis}</div>
                        <div class="harga">Rp ${harga.toLocaleString('id-ID')}</div>
                        <a href="${info.infoLink}" target="_blank" class="button">Beli</a>
                    </div>
                `;

                bookResults.innerHTML += card;
            });
        })
        .catch(error => {
            console.error("Error:", error);
            bookResults.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #e63946;"><p>Terjadi kesalahan saat mencari buku.</p></div>';
            bookResults.style.display = "grid";
            defaultBooks.style.display = "none";
        });
});

// Tekan Enter untuk search
document.getElementById("searchInput").addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        document.getElementById("searchBtn").click();
    }
});
</script>