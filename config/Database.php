<?php 
// Informasi koneksi ke database
$servername = "localhost"; // Nama server database (biasanya localhost)
$username = "root"; // Nama pengguna database
$password = ""; // Kata sandi database
$database = "si_penjualan_bahan_bangunan"; // Nama database yang ingin Anda hubungkan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}