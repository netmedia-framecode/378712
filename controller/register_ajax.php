<?php
require_once("../config/Base.php");

header('Content-Type: application/json'); // Mengatur balasan agar dibaca sebagai JSON oleh jQuery

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'register_cepat') {

  // Sanitasi input
  $name = valid($conn, $_POST['name']);
  $email = valid($conn, $_POST['email']);

  // Keamanan: Enkripsi password (sesuaikan jika kamu menggunakan MD5, tapi password_hash lebih disarankan)
  $password = password_hash(valid($conn, $_POST['password']), PASSWORD_DEFAULT);

  // 1. Cek apakah email sudah terdaftar
  $cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  if (mysqli_num_rows($cek_email) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal: Email ini sudah terdaftar.']);
    exit;
  }

  // 2. Insert data ke database 
  // (Asumsi tabel 'users'. Jika ada kolom id_role, sesuaikan. Misal: pelanggan = 3)
  $query = "INSERT INTO users (id_role, name, email, password) VALUES ('4', '$name', '$email', '$password')";

  if (mysqli_query($conn, $query)) {
    // 3. Auto Login: Ambil ID yang baru saja dibuat dan simpan ke session
    $id_user = mysqli_insert_id($conn);
    $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]['id'] = $id_user;
    $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]['id_role'] = 4;
    $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]['role'] = "Pelanggan";
    $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]['email'] = $email;
    $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]['name'] = $name;

    echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil! Memproses...']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Sistem sedang sibuk, coba lagi nanti.']);
  }
  exit;
}
