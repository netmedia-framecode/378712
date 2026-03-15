<?php

require_once("config/Base.php");
require_once("config/Alert.php");

// BERANDA
$query_produk = "SELECT k.kode_katalog, k.nama_barang, k.harga_barang, k.satuan, i.stok_tersedia 
                 FROM tabel_katalog k 
                 JOIN tabel_inventori i ON k.kode_katalog = i.kode_katalog 
                 WHERE i.stok_tersedia > 0 
                 ORDER BY RAND() LIMIT 4";
$result_produk = mysqli_query($conn, $query_produk);

// KATALOG
$keyword = "";
$search_query = "";
if (isset($_GET['q'])) {
  $keyword = mysqli_real_escape_string($conn, $_GET['q']);
  $search_query = " AND (k.nama_barang LIKE '%$keyword%' OR k.kode_katalog LIKE '%$keyword%')";
}
$query_semua_produk = "SELECT 
                            k.kode_katalog, 
                            k.nama_barang, 
                            k.harga_barang, 
                            k.satuan, 
                            i.stok_tersedia 
                       FROM tabel_katalog k 
                       JOIN tabel_inventori i ON k.kode_katalog = i.kode_katalog 
                       WHERE i.stok_tersedia > 0 
                       $search_query
                       ORDER BY k.nama_barang ASC";
$result_katalog = mysqli_query($conn, $query_semua_produk);
$total_produk = mysqli_num_rows($result_katalog);

if (!isset($_SESSION['keranjang'])) {
  $_SESSION['keranjang'] = [];
}
if (isset($_POST['add_to_cart'])) {
  $kode = valid($conn, $_POST['kode_katalog']);
  $qty = 1;
  if (isset($_SESSION['keranjang'][$kode])) {
    $_SESSION['keranjang'][$kode] += $qty;
  } else {
    $_SESSION['keranjang'][$kode] = $qty;
  }
  header("Location: keranjang");
  exit();
}
if (isset($_POST['update_cart'])) {
  foreach ($_POST['qty'] as $kode => $qty) {
    if ($qty > 0) {
      $_SESSION['keranjang'][$kode] = $qty;
    } else {
      unset($_SESSION['keranjang'][$kode]);
    }
  }
  header("Location: keranjang");
  exit();
}
if (isset($_GET['hapus_keranjang'])) {
  $kode = valid($conn, $_GET['hapus_keranjang']);
  unset($_SESSION['keranjang'][$kode]);
  header("Location: keranjang");
  exit();
}

// CHECKOUT
if (isset($_POST['proses_checkout'])) {
  if (!isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["id"]) || empty($_SESSION['keranjang'])) {
    header("Location: keranjang");
    exit();
  }
  $id_user = $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["id"];
  $query_pesanan = "INSERT INTO tabel_pesanan (id_user, status_pesanan, tanggal_pesan) 
                      VALUES ('$id_user', 'Menunggu Konfirmasi', CURRENT_TIMESTAMP)";
  if (mysqli_query($conn, $query_pesanan)) {
    $id_pesanan = mysqli_insert_id($conn);
    foreach ($_SESSION['keranjang'] as $kode => $qty) {
      $kode_bersih = mysqli_real_escape_string($conn, $kode);
      $qty = (int)$qty;

      // Ambil harga asli dari database (mencegah manipulasi harga dari browser)
      $cek_harga = mysqli_query($conn, "SELECT harga_barang FROM tabel_katalog WHERE kode_katalog = '$kode_bersih'");
      $row_harga = mysqli_fetch_assoc($cek_harga);
      $harga = $row_harga['harga_barang'];
      $total_harga = $harga * $qty;

      // Insert ke tabel_transaksi
      mysqli_query($conn, "INSERT INTO tabel_transaksi (id_pesanan, kode_katalog, jumlah_barang, total_harga, tanggal_transaksi) 
                                 VALUES ('$id_pesanan', '$kode_bersih', '$qty', '$total_harga', CURRENT_TIMESTAMP)");

      // Update / Potong stok di tabel_inventori
      mysqli_query($conn, "UPDATE tabel_inventori SET stok_tersedia = stok_tersedia - $qty WHERE kode_katalog = '$kode_bersih'");
    }

    // Bersihkan keranjang belanja setelah sukses
    unset($_SESSION['keranjang']);

    // Arahkan ke halaman sukses (bisa kamu buat nanti, untuk sementara arahkan ke index dengan parameter alert)
    header("Location: " . $baseURL . "?order=success&id=" . $id_pesanan);
    exit();
  } else {
    // Jika gagal insert master pesanan
    header("Location: " . $baseURL . "checkout?error=system");
    exit();
  }
}
