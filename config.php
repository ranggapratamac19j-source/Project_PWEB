<?php
$koneksi = mysqli_connect("localhost", "root", "", "project_pweb");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
