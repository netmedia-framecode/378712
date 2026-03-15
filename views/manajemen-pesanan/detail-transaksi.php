<?php require_once("../../controller/manajemen-pesanan.php");
if (!isset($_GET["p"])) {
  header("Location: transaksi");
  exit();
} else {
  $id = valid($conn, $_GET["p"]);

  // 1. Mengambil informasi umum pesanan dan data pelanggan
  $pull_pesanan = "SELECT 
                    tabel_pesanan.id_pesanan, 
                    tabel_pesanan.tanggal_pesan,
                    users.name,
                    users.email,
                    tabel_pelanggan.nomor_telepon,
                    tabel_pelanggan.alamat
                   FROM tabel_pesanan 
                   JOIN users ON tabel_pesanan.id_user = users.id_user 
                   LEFT JOIN tabel_pelanggan ON users.id_user = tabel_pelanggan.id_user
                   WHERE tabel_pesanan.id_pesanan = '$id' AND tabel_pesanan.status_pesanan = 'Selesai'";
  $store_pesanan = mysqli_query($conn, $pull_pesanan);
  $view_pesanan = mysqli_fetch_assoc($store_pesanan);

  // Jika ID tidak valid atau statusnya bukan 'Selesai', kembalikan ke halaman daftar transaksi
  if (!$view_pesanan) {
    header("Location: transaksi");
    exit();
  }

  // 2. Mengambil rincian daftar barang yang dibeli
  $pull_transaksi = "SELECT 
                      tabel_transaksi.id_transaksi,
                      tabel_transaksi.jumlah_barang,
                      tabel_transaksi.total_harga,
                      tabel_transaksi.tanggal_transaksi,
                      tabel_katalog.kode_katalog,
                      tabel_katalog.nama_barang,
                      tabel_katalog.harga_barang,
                      tabel_katalog.satuan
                     FROM tabel_transaksi 
                     JOIN tabel_katalog ON tabel_transaksi.kode_katalog = tabel_katalog.kode_katalog 
                     WHERE tabel_transaksi.id_pesanan = '$id'";
  $view_transaksi = mysqli_query($conn, $pull_transaksi);

  // Variabel penampung total belanja
  $grand_total = 0;
  $tanggal_selesai = '';

  $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Detail Transaksi";
  require_once("../../templates/views_top.php"); ?>

  <div class="nxl-content">

    <div class="page-header d-print-none">
      <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
          <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
        </div>
        <ul class="breadcrumb">
          <li class="breadcrumb-item">Manajemen Transaksi</li>
          <li class="breadcrumb-item">ORD-<?= str_pad($view_pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></li>
        </ul>
      </div>
      <div class="page-header-right ms-auto">
        <div class="d-flex align-items-center gap-2">
          <a href="transaksi" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Kembali
          </a>
          <a href="cetak-struk.php?p=<?= $view_pesanan['id_pesanan'] ?>" target="_blank" class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf me-2"></i> Cetak PDF
          </a>
        </div>
      </div>
    </div>
    <div class="main-content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card stretch stretch-full" id="invoice-card">
            <div class="card-body">

              <div class="row mb-5 border-bottom pb-4">
                <div class="col-sm-6">
                  <h4 class="fw-bold text-primary mb-3">INVOICE TRANSAKSI</h4>
                  <p class="mb-1 text-muted">ID Pesanan: <span class="fw-bold text-dark">ORD-<?= str_pad($view_pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></span></p>
                  <p class="mb-0 text-muted">Tgl. Pesan: <span class="fw-bold text-dark"><?= date('d M Y, H:i', strtotime($view_pesanan['tanggal_pesan'])) ?></span></p>
                </div>
                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                  <h6 class="fw-bold text-uppercase">Informasi Pelanggan</h6>
                  <p class="mb-1 fw-bold"><?= htmlspecialchars($view_pesanan['name']) ?></p>
                  <p class="mb-1 text-muted"><?= htmlspecialchars($view_pesanan['nomor_telepon'] ?? 'No. Telp belum diisi') ?></p>
                  <p class="mb-0 text-muted"><?= htmlspecialchars($view_pesanan['alamat'] ?? 'Alamat belum diisi') ?></p>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-center" width="5%">No</th>
                      <th class="text-center" width="15%">ID Transaksi</th>
                      <th width="35%">Deskripsi Barang</th>
                      <th class="text-end" width="15%">Harga Satuan</th>
                      <th class="text-center" width="10%">Qty</th>
                      <th class="text-end" width="20%">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    while ($item = mysqli_fetch_assoc($view_transaksi)) {
                      $grand_total += $item['total_harga'];
                      $tanggal_selesai = $item['tanggal_transaksi']; // Mengambil tanggal transaksi terakhir
                    ?>
                      <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center text-muted">TRX-<?= str_pad($item['id_transaksi'], 5, '0', STR_PAD_LEFT) ?></td>
                        <td>
                          <span class="fw-bold"><?= $item['nama_barang'] ?></span><br>
                          <small class="text-muted">Kode: <?= $item['kode_katalog'] ?></small>
                        </td>
                        <td class="text-end">Rp <?= number_format($item['harga_barang'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= $item['jumlah_barang'] ?> <?= $item['satuan'] ?></td>
                        <td class="text-end fw-bold">Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5" class="text-end fw-bold text-uppercase">Grand Total Pembayaran :</td>
                      <td class="text-end fw-bold fs-5 text-success">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="row mt-5">
                <div class="col-12 text-center text-muted">
                  <p class="mb-0">Transaksi diselesaikan pada: <strong><?= date('d M Y', strtotime($tanggal_selesai)) ?></strong></p>
                  <p>Terima kasih telah berbelanja di Toko Sumber Logam.</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php }
require_once("../../templates/views_bottom.php") ?>