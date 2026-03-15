<?php require_once("../../controller/manajemen-pesanan.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Transaksi";
require_once("../../templates/views_top.php"); ?>

<div class="nxl-content">

  <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Manajemen Pesanan</li>
        <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></li>
      </ul>
    </div>
  </div>
  <div class="main-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="card stretch stretch-full">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th class="text-center">Jumlah Transaksi</th>
                    <th class="text-end">Total Pembayaran</th>
                    <th class="text-center">Tanggal Selesai</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($views_transaksi as $key => $data) { ?>
                    <tr class="single-item">
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td class="text-center">
                        <span class="badge bg-light text-dark border">ORD-<?= str_pad($data['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></span>
                      </td>
                      <td class="fw-bold"><?= $data['nama_pembeli'] ?></td>
                      <td class="text-center">
                        <span class="badge bg-primary-subtle text-primary"><?= $data['total_item'] ?> Barang</span>
                      </td>
                      <td class="text-end fw-bold text-success">Rp <?= number_format($data['grand_total'], 0, ',', '.') ?></td>
                      <td class="text-center"><?= date('d M Y', strtotime($data['tanggal_transaksi'])) ?></td>
                      <td class="text-center">
                        <a href="detail-transaksi?p=<?= $data['id_pesanan'] ?>" class="btn btn-sm btn-info text-white gap-1" title="Lihat Detail Transaksi">
                          <i class="bi bi-eye"></i> Detail
                        </a>
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