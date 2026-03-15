<?php if (!isset($_SESSION)) {
  session_start();
}
require_once("../controller/auth.php");
if (isset($_SESSION["project_si_penjualan_bahan_bangunan"])) {
  unset($_SESSION["project_si_penjualan_bahan_bangunan"]);
  header("Location: ./");
  exit();
}
