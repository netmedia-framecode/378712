<?php

require_once("../../config/Base.php");
require_once("../../config/Auth.php");
require_once("../../config/Alert.php");
require_once("../../views/transaksi-penjualan/redirect.php");

$query_barang = "SELECT 
                    tabel_katalog.kode_katalog, 
                    tabel_katalog.nama_barang, 
                    tabel_katalog.harga_barang, 
                    tabel_katalog.satuan, 
                    tabel_inventori.stok_tersedia 
                 FROM tabel_katalog 
                 JOIN tabel_inventori ON tabel_katalog.kode_katalog = tabel_inventori.kode_katalog 
                 WHERE tabel_inventori.stok_tersedia > 0 
                 ORDER BY tabel_katalog.nama_barang ASC";
$views_barang = mysqli_query($conn, $query_barang);
if (isset($_POST["proses_penjualan"])) {
  if (empty($_POST['kode_katalog_pilih'])) {
    $message = "Gagal! Pilih minimal satu barang untuk diproses.";
    $message_type = "danger";
    alert($message, $message_type);
    header("Location: input-penjualan-baru");
    exit();
  }
  $id_pesanan_baru = penjualan($conn, $_POST, 'insert', $id_user);
  if ($id_pesanan_baru > 0) {
    $message = "Transaksi Berhasil! Silakan cetak struk pembayaran.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: detail-transaksi?p=" . $id_pesanan_baru);
    exit();
  } else {
    $message = "Terjadi kesalahan sistem saat memproses transaksi.";
    $message_type = "danger";
    alert($message, $message_type);
    header("Location: input-penjualan-baru");
    exit();
  }
}

$query_daftar_transaksi = "SELECT 
                              tabel_pesanan.id_pesanan,
                              tabel_pesanan.tanggal_pesan,
                              users.name AS nama_kasir,
                              COUNT(tabel_transaksi.id_transaksi) AS total_item,
                              SUM(tabel_transaksi.total_harga) AS grand_total
                           FROM tabel_pesanan
                           JOIN users ON tabel_pesanan.id_user = users.id_user
                           JOIN tabel_transaksi ON tabel_pesanan.id_pesanan = tabel_transaksi.id_pesanan
                           WHERE tabel_pesanan.status_pesanan = 'Selesai'
                           GROUP BY tabel_pesanan.id_pesanan, users.name, tabel_pesanan.tanggal_pesan
                           ORDER BY tabel_pesanan.tanggal_pesan DESC";
$views_daftar_transaksi = mysqli_query($conn, $query_daftar_transaksi);
