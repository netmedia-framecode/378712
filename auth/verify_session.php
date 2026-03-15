<?php
require_once("../controller/auth.php");
if (isset($_SESSION["project_si_penjualan_bahan_bangunan"])) {
  header("Location: ../views/");
  exit;
} else {
  if (!isset($_SESSION["data_auth"]["en_user"])) {
    $_SESSION["project_si_penjualan_bahan_bangunan"] = [
      "message-warning" => "Maaf, sepertinya ada kesalahan saat mendaftar.",
      "time-message" => time()
    ];
    header("Location: register");
    exit;
  } else {
    $message = "Waktu verifikasi telah habis!";
    $response = ["message" => $message];
    echo json_encode($response);
  }
}

