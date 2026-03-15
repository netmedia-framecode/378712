<?php require_once("../../controller/transaksi-penjualan.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Daftar Transaksi";
require_once("../../templates/views_top.php"); ?>

<div class="nxl-content">

  <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Transaksi Penjualan</li>
        <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></li>
      </ul>
    </div>
  </div>
  <div class="main-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="card stretch stretch-full border-0 shadow-sm">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" id="dataTable">
                <thead class="bg-light text-muted">
                  <tr>
                    <th class="text-center py-3" width="5%">No</th>
                    <th class="py-3 text-center" width="15%">Tanggal</th>
                    <th class="py-3 text-center" width="15%">ID Pesanan</th>
                    <th class="py-3" width="20%">Kasir Penanggung Jawab</th>
                    <th class="text-center py-3" width="15%">Total Item</th>
                    <th class="text-end py-3 pe-4" width="15%">Total Harga</th>
                    <th class="text-center py-3" width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if (isset($views_daftar_transaksi) && mysqli_num_rows($views_daftar_transaksi) > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($views_daftar_transaksi)) { 
                  ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border"><?= date('d M Y, H:i', strtotime($data['tanggal_pesan'])) ?></span>
                    </td>
                    <td class="text-center fw-semibold text-primary">
                        ORD-<?= str_pad($data['id_pesanan'], 4, '0', STR_PAD_LEFT) ?>
                    </td>
                    <td class="fw-semibold"><?= htmlspecialchars($data['nama_kasir']) ?></td>
                    <td class="text-center">
                        <span class="badge bg-secondary-subtle text-secondary"><?= $data['total_item'] ?> Barang</span>
                    </td>
                    <td class="text-end fw-bold text-success pe-4">Rp <?= number_format($data['grand_total'], 0, ',', '.') ?></td>
                    <td class="text-center">
                      <a href="detail-transaksi?p=<?= $data['id_pesanan'] ?>" class="btn btn-sm btn-primary shadow-sm gap-1" title="Lihat & Cetak Struk">
                        <i class="bi bi-printer"></i> Cetak Struk
                      </a>
                    </td>
                  </tr>
                  <?php 
                    } 
                  } else {
                  ?>
                  <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada riwayat transaksi yang diselesaikan.
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

<?php require_once("../../templates/views_bottom.php") ?>