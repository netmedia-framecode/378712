<?php require_once("../../controller/katalog.php");
if (!isset($_GET["p"])) {
  header("Location: daftar-barang");
  exit();
} else {
  $id = valid($conn, $_GET["p"]);
  $pull_data = "SELECT * FROM tabel_katalog WHERE kode_katalog = '$id'";
  $store_data = mysqli_query($conn, $pull_data);
  $view_data = mysqli_fetch_assoc($store_data);
  if (!$view_data) {
    header("Location: daftar-barang");
    exit();
  }

  $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Ubah Daftar Barang";
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

                <input type="hidden" name="kode_katalogOld" value="<?= htmlspecialchars($view_data['kode_katalog']) ?>">
                <input type="hidden" name="nama_barangOld" value="<?= htmlspecialchars($view_data['nama_barang']) ?>">

                <div class="mb-3">
                  <label for="kode_katalog" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="kode_katalog" name="kode_katalog" value="<?= htmlspecialchars($view_data['kode_katalog']) ?>" required>
                  <small class="text-muted">Pastikan kode barang unik dan tidak ada spasi.</small>
                </div>

                <div class="mb-3">
                  <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($view_data['nama_barang']) ?>" required>
                </div>

                <div class="mb-3">
                  <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="satuan" name="satuan" value="<?= htmlspecialchars($view_data['satuan']) ?>" required>
                </div>

                <div class="mb-3">
                  <label for="deskripsi_barang" class="form-label">Deskripsi Barang</label>
                  <textarea class="form-control" id="deskripsi_barang" name="deskripsi_barang" rows="3"><?= htmlspecialchars($view_data['deskripsi_barang']) ?></textarea>
                </div>

                <div class="mb-4">
                  <label for="harga_barang" class="form-label">Harga Barang (Rp) <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="harga_barang" name="harga_barang" min="0" value="<?= htmlspecialchars($view_data['harga_barang']) ?>" required>
                </div>

                <div class="d-flex justify-content-start gap-2">
                  <a href="daftar-barang" class="btn btn-secondary">Batal</a>
                  <button type="submit" name="edit_barang" class="btn btn-primary">Simpan Perubahan</button>
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