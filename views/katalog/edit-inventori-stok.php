<?php require_once("../../controller/katalog.php");
if (!isset($_GET["p"])) {
  header("Location: inventori-stok");
  exit();
} else {
  $id = valid($conn, $_GET["p"]);

  // Mengambil data inventori beserta nama barang dari tabel_katalog
  $pull_data = "SELECT 
                  tabel_inventori.*, 
                  tabel_katalog.nama_barang, 
                  tabel_katalog.satuan 
                FROM tabel_inventori 
                JOIN tabel_katalog ON tabel_inventori.kode_katalog = tabel_katalog.kode_katalog 
                WHERE tabel_inventori.id_inventori = '$id'";

  $store_data = mysqli_query($conn, $pull_data);
  $view_data = mysqli_fetch_assoc($store_data);

  // Jika data tidak ditemukan di database, kembalikan ke daftar inventori
  if (!$view_data) {
    header("Location: inventori-stok");
    exit();
  }

  $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Ubah Inventori Stok";
  require_once("../../templates/views_top.php"); ?>

  <div class="nxl-content" style="height: 100vh;">

    <div class="page-header">
      <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
          <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
        </div>
        <ul class="breadcrumb">
          <li class="breadcrumb-item">Katalog</li>
          <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] . ' - ' . htmlspecialchars($view_data["nama_barang"])  ?></li>
        </ul>
      </div>
    </div>
    <div class="main-content">
      <div class="row">
        <div class="col-lg-6">
          <div class="card stretch stretch-full">
            <div class="card-body">
              <form action="" method="POST">

                <input type="hidden" name="id_inventori" value="<?= $view_data['id_inventori'] ?>">

                <div class="mb-3">
                  <label for="kode_katalog" class="form-label">Kode Barang</label>
                  <input type="text" class="form-control" id="kode_katalog" name="kode_katalog" value="<?= htmlspecialchars($view_data['kode_katalog']) ?>" readonly>
                  <small class="text-muted">Kode barang tidak dapat diubah di sini.</small>
                </div>

                <div class="mb-3">
                  <label for="nama_barang" class="form-label">Nama Barang</label>
                  <input type="text" class="form-control" id="nama_barang" value="<?= htmlspecialchars($view_data['nama_barang']) ?> (<?= htmlspecialchars($view_data['satuan']) ?>)" readonly>
                </div>

                <div class="mb-4">
                  <label for="stok_tersedia" class="form-label">Stok Tersedia <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="stok_tersedia" name="stok_tersedia" min="0" value="<?= htmlspecialchars($view_data['stok_tersedia']) ?>" required>
                  <small class="text-info"><i class="bi bi-info-circle"></i> Masukkan jumlah stok fisik saat ini hasil opname (pengecekan langsung).</small>
                </div>

                <div class="d-flex justify-content-start gap-2">
                  <a href="inventori-stok" class="btn btn-secondary">Batal</a>
                  <button type="submit" name="edit_inventori" class="btn btn-primary">Simpan Perubahan Stok</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php }
require_once("../../templates/views_bottom.php") ?>