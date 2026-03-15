<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$bulan_ini = date('m');
$tahun_ini = date('Y');

$query_pendapatan = "SELECT SUM(tabel_transaksi.total_harga) AS total_pendapatan 
                     FROM tabel_transaksi 
                     JOIN tabel_pesanan ON tabel_transaksi.id_pesanan = tabel_pesanan.id_pesanan 
                     WHERE tabel_pesanan.status_pesanan = 'Selesai' 
                     AND MONTH(tabel_transaksi.tanggal_transaksi) = '$bulan_ini' 
                     AND YEAR(tabel_transaksi.tanggal_transaksi) = '$tahun_ini'";
$result_pendapatan = mysqli_query($conn, $query_pendapatan);
$total_pendapatan = mysqli_fetch_assoc($result_pendapatan)['total_pendapatan'] ?? 0;

$query_pesanan = "SELECT COUNT(id_pesanan) AS total_pesanan FROM tabel_pesanan 
                  WHERE status_pesanan = 'Selesai' 
                  AND MONTH(tanggal_pesan) = '$bulan_ini' 
                  AND YEAR(tanggal_pesan) = '$tahun_ini'";
$total_pesanan = mysqli_fetch_assoc(mysqli_query($conn, $query_pesanan))['total_pesanan'] ?? 0;

$query_barang = "SELECT SUM(jumlah_barang) AS total_barang FROM tabel_transaksi 
                 JOIN tabel_pesanan ON tabel_transaksi.id_pesanan = tabel_pesanan.id_pesanan 
                 WHERE tabel_pesanan.status_pesanan = 'Selesai' 
                 AND MONTH(tabel_transaksi.tanggal_transaksi) = '$bulan_ini'";
$total_barang_terjual = mysqli_fetch_assoc(mysqli_query($conn, $query_barang))['total_barang'] ?? 0;

$query_stok_menipis = "SELECT tabel_katalog.nama_barang, tabel_inventori.stok_tersedia, tabel_katalog.satuan 
                       FROM tabel_inventori 
                       JOIN tabel_katalog ON tabel_inventori.kode_katalog = tabel_katalog.kode_katalog 
                       WHERE tabel_inventori.stok_tersedia <= 10 
                       ORDER BY tabel_inventori.stok_tersedia ASC LIMIT 5";
$stok_menipis = mysqli_query($conn, $query_stok_menipis);
$jumlah_stok_menipis = mysqli_num_rows(mysqli_query($conn, "SELECT id_inventori FROM tabel_inventori WHERE stok_tersedia <= 10"));

$query_transaksi_terbaru = "SELECT 
                              tabel_pesanan.id_pesanan,
                              tabel_pesanan.tanggal_pesan,
                              tabel_pesanan.status_pesanan,
                              users.name AS nama_kasir,
                              SUM(tabel_transaksi.total_harga) AS grand_total
                           FROM tabel_pesanan
                           LEFT JOIN users ON tabel_pesanan.id_user = users.id_user
                           LEFT JOIN tabel_transaksi ON tabel_pesanan.id_pesanan = tabel_transaksi.id_pesanan
                           GROUP BY tabel_pesanan.id_pesanan
                           ORDER BY tabel_pesanan.tanggal_pesan DESC LIMIT 5";
$transaksi_terbaru = mysqli_query($conn, $query_transaksi_terbaru);

$query_bar = "SELECT tabel_katalog.nama_barang, SUM(tabel_transaksi.jumlah_barang) AS total_terjual
              FROM tabel_transaksi
              JOIN tabel_katalog ON tabel_transaksi.kode_katalog = tabel_katalog.kode_katalog
              JOIN tabel_pesanan ON tabel_transaksi.id_pesanan = tabel_pesanan.id_pesanan
              WHERE tabel_pesanan.status_pesanan = 'Selesai'
              GROUP BY tabel_katalog.kode_katalog
              ORDER BY total_terjual DESC LIMIT 5";
$result_bar = mysqli_query($conn, $query_bar);
$bar_labels = [];
$bar_data = [];
if ($result_bar) {
  while ($row = mysqli_fetch_assoc($result_bar)) {
    $bar_labels[] = $row['nama_barang'];
    $bar_data[] = (int)$row['total_terjual'];
  }
}

$query_pie = "SELECT status_pesanan, COUNT(id_pesanan) AS jumlah 
              FROM tabel_pesanan 
              GROUP BY status_pesanan";
$result_pie = mysqli_query($conn, $query_pie);
$pie_labels = [];
$pie_data = [];
if ($result_pie) {
  while ($row = mysqli_fetch_assoc($result_pie)) {
    $pie_labels[] = $row['status_pesanan'];
    $pie_data[] = (int)$row['jumlah'];
  }
}
