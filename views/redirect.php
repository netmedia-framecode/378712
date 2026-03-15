<?php
if (!isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"])) {
  header("Location: ../auth/");
  exit;
} else {
  if ($id_role == 4) {
    header("Location: ../");
    exit();
  }
}
