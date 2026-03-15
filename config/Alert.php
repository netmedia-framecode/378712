<?php

$messageTypes = ["success", "info", "warning", "danger", "dark"];

if (!isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"])) {
  if (isset($_SESSION["project_si_penjualan_bahan_bangunan"]["time_message"]) && (time() - $_SESSION["project_si_penjualan_bahan_bangunan"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_si_penjualan_bahan_bangunan"]["message_$type"])) {
        unset($_SESSION["project_si_penjualan_bahan_bangunan"]["message_$type"]);
      }
    }
    unset($_SESSION["project_si_penjualan_bahan_bangunan"]["time_message"]);
  }
} else if (isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"])) {
  if (isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["time_message"]) && (time() - $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["message_$type"])) {
        unset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["message_$type"]);
      }
    }
    unset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["time_message"]);
  }
}
