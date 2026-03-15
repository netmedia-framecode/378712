<?php

require_once("../../config/Base.php");
require_once("../../config/Auth.php");
require_once("../../config/Alert.php");
require_once("../../views/laporan/redirect.php");

$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query untuk mengambil data transaksi yang "Selesai", di-filter berdasarkan bulan dan tahun
$query_laporan = "SELECT 
                    tabel_pesanan.id_pesanan,
                    users.name AS nama_pembeli,
                    COUNT(tabel_transaksi.id_transaksi) AS total_item,
                    SUM(tabel_transaksi.total_harga) AS grand_total,
                    MAX(tabel_transaksi.tanggal_transaksi) AS tanggal_transaksi
                  FROM tabel_pesanan
                  JOIN users ON tabel_pesanan.id_user = users.id_user
                  JOIN tabel_transaksi ON tabel_pesanan.id_pesanan = tabel_transaksi.id_pesanan
                  WHERE tabel_pesanan.status_pesanan = 'Selesai' 
                    AND MONTH(tabel_transaksi.tanggal_transaksi) = '$filter_bulan'
                    AND YEAR(tabel_transaksi.tanggal_transaksi) = '$filter_tahun'
                  GROUP BY tabel_pesanan.id_pesanan, users.name
                  ORDER BY tanggal_transaksi ASC";
$views_laporan = mysqli_query($conn, $query_laporan);
