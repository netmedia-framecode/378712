<?php require_once("../../controller/laporan.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Laporan Penjualan";
require_once("../../templates/views_top.php");

// Menangkap nilai filter
$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

// Kalkulasi Data Awal untuk KPI Cards
$laporan_data = [];
$grand_total_pendapatan = 0;
$total_transaksi = 0;
$total_barang_terjual = 0;

if (mysqli_num_rows($views_laporan) > 0) {
  while ($row = mysqli_fetch_assoc($views_laporan)) {
    $laporan_data[] = $row;
    $grand_total_pendapatan += $row['grand_total'];
    $total_transaksi++;
    $total_barang_terjual += $row['total_item'];
  }
}
?>

<div class="nxl-content">

  <div class="page-header d-print-none">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Laporan</li>
        <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></li>
      </ul>
    </div>
    <div class="page-header-right ms-auto">
      <div class="d-flex align-items-center gap-2">
        <a href="export-excel.php?bulan=<?= $filter_bulan ?>&tahun=<?= $filter_tahun ?>" class="btn btn-success shadow-sm">
          <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
        </a>
        <button onclick="window.print()" class="btn btn-primary shadow-sm">
          <i class="bi bi-printer me-2"></i> Cetak PDF
        </button>
      </div>
    </div>
  </div>
  <div class="main-content" id="print-area">

    <div class="d-none d-print-block text-center mb-4 border-bottom pb-3">
      <h3 class="fw-bold mb-0">LAPORAN PENJUALAN TOKO SUMBER LOGAM</h3>
      <p class="text-muted mb-0">Periode: <?= $nama_bulan[(int)$filter_bulan] ?> <?= $filter_tahun ?></p>
    </div>

    <div class="card shadow-sm mb-4 border-0 d-print-none">
      <div class="card-body bg-light rounded">
        <form action="" method="GET" class="row g-3 align-items-end">
          <div class="col-md-4">
            <label for="bulan" class="form-label fw-semibold text-muted">Periode Bulan</label>
            <select name="bulan" id="bulan" class="form-select border-0 shadow-sm">
              <?php
              for ($i = 1; $i <= 12; $i++) {
                $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                $selected = ($val == $filter_bulan) ? "selected" : "";
                echo "<option value='{$val}' {$selected}>{$nama_bulan[$i]}</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <label for="tahun" class="form-label fw-semibold text-muted">Tahun</label>
            <select name="tahun" id="tahun" class="form-select border-0 shadow-sm">
              <?php
              $tahun_sekarang = date('Y');
              for ($t = $tahun_sekarang - 2; $t <= $tahun_sekarang; $t++) {
                $selected = ($t == $filter_tahun) ? "selected" : "";
                echo "<option value='{$t}' {$selected}>{$t}</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-dark w-100 shadow-sm">
              <i class="bi bi-funnel me-2"></i> Terapkan Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-primary">
          <div class="card-body d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-wallet2 display-6"></i>
            </div>
            <div>
              <p class="mb-0 fw-semibold opacity-75">Total Pendapatan</p>
              <h4 class="fw-bold mb-0">Rp <?= number_format($grand_total_pendapatan, 0, ',', '.') ?></h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mt-3 mt-md-0">
        <div class="card border-0 shadow-sm bg-success text-white">
          <div class="card-body d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-cart-check display-6"></i>
            </div>
            <div>
              <p class="mb-0 fw-semibold opacity-75">Pesanan Selesai</p>
              <h4 class="fw-bold mb-0"><?= number_format($total_transaksi, 0, ',', '.') ?> Transaksi</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mt-3 mt-md-0">
        <div class="card border-0 shadow-sm bg-info text-white">
          <div class="card-body d-flex align-items-center">
            <div class="me-3">
              <i class="bi bi-box-seam display-6"></i>
            </div>
            <div>
              <p class="mb-0 fw-semibold opacity-75">Barang Terjual</p>
              <h4 class="fw-bold mb-0"><?= number_format($total_barang_terjual, 0, ',', '.') ?> Item</h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3">
        <h6 class="card-title mb-0 fw-bold">Rincian Transaksi - <?= $nama_bulan[(int)$filter_bulan] ?> <?= $filter_tahun ?></h6>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-borderless table-striped align-middle mb-0">
            <thead class="bg-light text-muted">
              <tr>
                <th class="text-center py-3" width="5%">No</th>
                <th class="py-3" width="15%">Tanggal</th>
                <th class="py-3" width="20%">ID Pesanan</th>
                <th class="py-3" width="30%">Nama Pelanggan</th>
                <th class="text-center py-3" width="15%">Item Terjual</th>
                <th class="text-end py-3 pe-4" width="15%">Nominal</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($laporan_data)) {
                $no = 1;
                foreach ($laporan_data as $data) {
              ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td>
                      <span class="badge bg-light text-dark border"><?= date('d M Y h:i A', strtotime($data['tanggal_transaksi'])) ?></span>
                    </td>
                    <td class="fw-semibold text-primary">ORD-<?= str_pad($data['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="fw-semibold"><?= $data['nama_pembeli'] ?></td>
                    <td class="text-center"><?= $data['total_item'] ?> Barang</td>
                    <td class="text-end fw-bold text-success pe-4">Rp <?= number_format($data['grand_total'], 0, ',', '.') ?></td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                    Belum ada transaksi yang diselesaikan pada periode ini.
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

<style>
  @media print {
    body * {
      visibility: hidden;
    }

    #print-area,
    #print-area * {
      visibility: visible;
    }

    #print-area {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      margin: 0;
      padding: 0;
    }

    .card {
      border: none !important;
      box-shadow: none !important;
    }

    .bg-primary,
    .bg-success,
    .bg-info {
      background-color: transparent !important;
      color: #000 !important;
      border: 1px solid #ccc !important;
    }

    .text-white {
      color: #000 !important;
    }

    .opacity-75 {
      opacity: 1 !important;
    }

    .table-responsive {
      overflow: visible !important;
    }

    table {
      width: 100% !important;
      border-collapse: collapse !important;
    }

    th,
    td {
      border: 1px solid #ddd !important;
      padding: 8px !important;
    }

    .d-print-none {
      display: none !important;
    }
  }
</style>

<?php require_once("../../templates/views_bottom.php") ?>