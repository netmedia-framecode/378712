<?php
require_once("../config/Base.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_pelanggan') {

  // Pastikan session masih ada
  if (!isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Sesi berakhir. Silakan login ulang.']);
    exit;
  }

  $id_user = $_SESSION['project_si_penjualan_bahan_bangunan']['users']['id'];
  $no_telp = valid($conn, $_POST['no_telp']);
  $alamat = valid($conn, $_POST['alamat']);

  // Cek apakah data pelanggan sudah ada di tabel_pelanggan sebelumnya
  $cek_pelanggan = mysqli_query($conn, "SELECT id_pelanggan FROM tabel_pelanggan WHERE id_user = '$id_user'");

  if (mysqli_num_rows($cek_pelanggan) > 0) {
    // Jika sudah ada, lakukan UPDATE
    $query = "UPDATE tabel_pelanggan SET nomor_telepon = '$no_telp', alamat = '$alamat' WHERE id_user = '$id_user'";
  } else {
    // Jika belum ada (misal baru daftar dari form cepat), lakukan INSERT
    $query = "INSERT INTO tabel_pelanggan (id_user, nomor_telepon, alamat) VALUES ('$id_user', '$no_telp', '$alamat')";
  }

  if (mysqli_query($conn, $query)) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Data pengiriman berhasil disimpan!',
      'no_telp' => $no_telp,
      'alamat' => $alamat
    ]);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database.']);
  }
  exit;
}
