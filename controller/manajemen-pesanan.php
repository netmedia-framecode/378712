<?php

require_once("../../config/Base.php");
require_once("../../config/Auth.php");
require_once("../../config/Alert.php");
require_once("../../views/manajemen-pesanan/redirect.php");

$select_pesanan = "SELECT 
    tabel_pesanan.id_pesanan,
    tabel_pesanan.tanggal_pesan,
    tabel_pesanan.status_pesanan,
    users.name
FROM tabel_pesanan
JOIN users ON tabel_pesanan.id_user = users.id_user
ORDER BY tabel_pesanan.tanggal_pesan DESC";
$views_pesanan = mysqli_query($conn, $select_pesanan);
if (isset($_POST["edit_pesanan"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  pesanan($conn, $validated_post, $action = 'update');
  $message = "Status pesanan berhasil diperbarui menjadi " . $_POST['status_pesanan'] . ".";
  $message_type = "success";
  alert($message, $message_type);
  header("Location: pesanan");
  exit();
}
if (isset($_POST["delete_pesanan"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pesanan($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Data pesanan berhasil dihapus dari sistem.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pesanan");
    exit();
  }
}

$select_transaksi = "SELECT 
    tabel_pesanan.id_pesanan,
    users.name AS nama_pembeli,
    COUNT(tabel_transaksi.id_transaksi) AS total_item,
    SUM(tabel_transaksi.total_harga) AS grand_total,
    MAX(tabel_transaksi.tanggal_transaksi) AS tanggal_transaksi
FROM tabel_pesanan
JOIN users ON tabel_pesanan.id_user = users.id_user
JOIN tabel_transaksi ON tabel_pesanan.id_pesanan = tabel_transaksi.id_pesanan
WHERE tabel_pesanan.status_pesanan = 'Selesai'
GROUP BY tabel_pesanan.id_pesanan, users.name
ORDER BY tanggal_transaksi DESC, tabel_pesanan.id_pesanan DESC";
$views_transaksi = mysqli_query($conn, $select_transaksi);