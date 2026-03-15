<?php

if (!isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"])) {
  function alert($message, $message_type)
  {
    $_SESSION["project_si_penjualan_bahan_bangunan"] = [
      "message_$message_type" => $message,
      "time_message" => time()
    ];

    return true;
  }
}

if (isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"])) {
  function alert($message, $message_type)
  {
    global $conn;
    $id_user = valid($conn, $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["id"]);
    $id_role = valid($conn, $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["id_role"]);
    $role = valid($conn, $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["role"]);
    $email = valid($conn, $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["email"]);
    $name = valid($conn, $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["name"]);
    $image = valid($conn, $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["image"]);

    $_SESSION["project_si_penjualan_bahan_bangunan"]["users"] = [
      "id" => $id_user,
      "id_role" => $id_role,
      "role" => $role,
      "email" => $email,
      "name" => $name,
      "image" => $image,
      "message_$message_type" => $message,
      "time_message" => time()
    ];
  }
}
