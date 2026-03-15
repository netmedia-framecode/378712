<?php require_once("../../controller/manajemen-pesanan.php");
if (!isset($_GET["p"])) {
  header("Location: pesanan");
  exit();
} else {
  $id = valid($conn, $_GET["p"]);

  // 1. Mengambil data utama pesanan dan nama pelanggan
  $pull_pesanan = "SELECT 
                    tabel_pesanan.*, 
                    users.name,
                    users.email
                   FROM tabel_pesanan 
                   JOIN users ON tabel_pesanan.id_user = users.id_user 
                   WHERE tabel_pesanan.id_pesanan = '$id'";
  $store_pesanan = mysqli_query($conn, $pull_pesanan);
  $view_pesanan = mysqli_fetch_assoc($store_pesanan);

  if (!$view_pesanan) {
    header("Location: pesanan");
    exit();
  }

  // 2. Mengambil rincian barang yang dibeli (dari tabel_transaksi & tabel_katalog)
  $pull_transaksi = "SELECT 
                      tabel_transaksi.*, 
                      tabel_katalog.nama_barang,
                      tabel_katalog.harga_barang,
                      tabel_katalog.satuan
                     FROM tabel_transaksi 
                     JOIN tabel_katalog ON tabel_transaksi.kode_katalog = tabel_katalog.kode_katalog 
                     WHERE tabel_transaksi.id_pesanan = '$id'";
  $view_transaksi = mysqli_query($conn, $pull_transaksi);

  // Menghitung grand total
  $grand_total = 0;

  $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Detail & Update Pesanan";
  require_once("../../templates/views_top.php"); ?>

  <div class="nxl-content">

    <div class="page-header">
      <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
          <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
        </div>
        <ul class="breadcrumb">
          <li class="breadcrumb-item">Manajemen Pesanan</li>
          <li class="breadcrumb-item">ORD-<?= str_pad($view_pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></li>
        </ul>
      </div>
    </div>
    <div class="main-content">
      <div class="row">

        <div class="col-lg-4">
          <div class="card stretch stretch-full">
            <div class="card-header">
              <h5 class="card-title">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
              <form action="" method="POST">
                <input type="hidden" name="id_pesanan" value="<?= $view_pesanan['id_pesanan'] ?>">

                <div class="mb-3">
                  <label class="form-label text-muted">Pelanggan</label>
                  <p class="fw-bold mb-0"><?= htmlspecialchars($view_pesanan['name']) ?></p>
                  <small class="text-muted"><?= htmlspecialchars($view_pesanan['email']) ?></small>
                </div>

                <div class="mb-3">
                  <label class="form-label text-muted">Tanggal Pesan</label>
                  <p class="fw-bold"><?= date('d F Y, H:i', strtotime($view_pesanan['tanggal_pesan'])) ?></p>
                </div>

                <hr>

                <div class="mb-4">
                  <label for="status_pesanan" class="form-label">Update Status Pesanan <span class="text-danger">*</span></label>
                  <select class="form-select fw-bold" id="status_pesanan" name="status_pesanan" required>
                    <option value="Menunggu Konfirmasi" <?= ($view_pesanan['status_pesanan'] == 'Menunggu Konfirmasi') ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                    <option value="Diproses" <?= ($view_pesanan['status_pesanan'] == 'Diproses') ? 'selected' : '' ?>>Diproses</option>
                    <option value="Selesai" <?= ($view_pesanan['status_pesanan'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                    <option value="Batal" <?= ($view_pesanan['status_pesanan'] == 'Batal') ? 'selected' : '' ?>>Batal</option>
                  </select>
                </div>

                <div class="d-grid gap-2">
                  <button type="submit" name="edit_pesanan" class="btn btn-primary">Simpan Status</button>
                  <a href="pesanan" class="btn btn-light">Kembali</a>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card stretch stretch-full">
            <div class="card-header">
              <h5 class="card-title">Rincian Barang Pesanan</h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Nama Barang</th>
                      <th class="text-end">Harga Satuan</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-end">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    while ($item = mysqli_fetch_assoc($view_transaksi)) {
                      $grand_total += $item['total_harga'];
                    ?>
                      <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                          <span class="fw-bold"><?= $item['nama_barang'] ?></span><br>
                          <small class="text-muted">Kode: <?= $item['kode_katalog'] ?></small>
                        </td>
                        <td class="text-end">Rp <?= number_format($item['harga_barang'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= $item['jumlah_barang'] ?> <?= $item['satuan'] ?></td>
                        <td class="text-end fw-bold text-primary">Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr class="bg-light">
                      <td colspan="4" class="text-end fw-bold fs-5">Total Pembayaran:</td>
                      <td class="text-end fw-bold fs-5 text-success">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

<?php }
require_once("../../templates/views_bottom.php") ?>