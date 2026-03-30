<?php

require_once("../../config/Base.php");
require_once("../../config/Auth.php");
require_once("../../config/Alert.php");
require_once("../../views/katalog/redirect.php");

$select_barang = "SELECT 
    tabel_katalog.kode_katalog,
    tabel_katalog.nama_barang,
    tabel_katalog.satuan,
    tabel_katalog.deskripsi_barang,
    tabel_katalog.harga_barang,
    tabel_inventori.stok_tersedia,
    tabel_katalog.gambar_barang
FROM tabel_katalog
LEFT JOIN tabel_inventori ON tabel_katalog.kode_katalog = tabel_inventori.kode_katalog
ORDER BY tabel_katalog.nama_barang ASC";
$views_barang = mysqli_query($conn, $select_barang);
if (isset($_POST["add_barang"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (barang($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Barang baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-barang");
    exit();
  }
}
if (isset($_POST["edit_barang"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (barang($conn, $validated_post, $action = 'update') > 0) {
    $message = "Barang " . $_POST['nama_barangOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-barang");
    exit();
  }
}
if (isset($_POST["delete_barang"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (barang($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Barang " . $_POST['nama_barang'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-barang");
    exit();
  }
}

$select_inventori = "SELECT 
    tabel_inventori.id_inventori,
    tabel_inventori.kode_katalog,
    tabel_katalog.nama_barang,
    tabel_katalog.satuan,
    tabel_inventori.stok_tersedia,
    tabel_katalog.gambar_barang,
    tabel_inventori.terakhir_diupdate
FROM tabel_inventori
JOIN tabel_katalog ON tabel_inventori.kode_katalog = tabel_katalog.kode_katalog
ORDER BY tabel_inventori.terakhir_diupdate DESC";
$views_inventori = mysqli_query($conn, $select_inventori);
if (isset($_POST["add_inventori"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (inventori($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Stok awal barang berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: inventori-stok");
    exit();
  }
}
if (isset($_POST["edit_inventori"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (inventori($conn, $validated_post, $action = 'update') > 0) {
    $message = "Data stok barang berhasil diperbarui.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: inventori-stok");
    exit();
  }
}
if (isset($_POST["delete_inventori"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (inventori($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Data stok barang berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: inventori-stok");
    exit();
  }
}
