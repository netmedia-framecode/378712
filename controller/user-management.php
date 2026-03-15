<?php

require_once("../../config/Base.php");
require_once("../../config/Auth.php");
require_once("../../config/Alert.php");
require_once("../../views/user-management/redirect.php");

$select_users = "SELECT users.*, user_role.role, user_status.status 
FROM users
JOIN user_role ON users.id_role=user_role.id_role 
JOIN user_status ON users.id_active=user_status.id_status
WHERE users.id_role != 4 AND user_role.role != 'Pelanggan' AND users.id_user != $id_user
";
$views_users = mysqli_query($conn, $select_users);
$select_user_role = "SELECT * FROM user_role";
$views_user_role = mysqli_query($conn, $select_user_role);
$select_user_status = "SELECT * FROM user_status";
$views_user_status = mysqli_query($conn, $select_user_status);
if (isset($_POST["edit_users"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (users($conn, $validated_post, $action = 'update') > 0) {
    $message = "data users berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: users");
    exit();
  }
}
if (isset($_POST["add_role"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (role($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Role baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: role");
    exit();
  }
}
if (isset($_POST["edit_role"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (role($conn, $validated_post, $action = 'update') > 0) {
    $message = "Role " . $_POST['roleOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: role");
    exit();
  }
}
if (isset($_POST["delete_role"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (role($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Role " . $_POST['role'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: role");
    exit();
  }
}

$select_pelanggan = "SELECT 
    users.id_user,
    tabel_pelanggan.id_pelanggan,
    users.name,
    users.email,
    tabel_pelanggan.nomor_telepon,
    tabel_pelanggan.alamat,
    user_status.status
FROM users
JOIN user_role ON users.id_role = user_role.id_role
JOIN user_status ON users.id_active = user_status.id_status
LEFT JOIN tabel_pelanggan ON users.id_user = tabel_pelanggan.id_user
WHERE user_role.role = 'Pelanggan'";
$views_pelanggan = mysqli_query($conn, $select_pelanggan);
if (isset($_POST["edit_pelanggan"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pelanggan($conn, $validated_post, $action = 'update') > 0) {
    $message = "data pelanggan berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pelanggan");
    exit();
  }
}
