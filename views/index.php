<?php require_once("../controller/dashboard.php"); // Pastikan path benar
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Dashboard";
require_once("../templates/views_top.php"); ?>

<div class="nxl-content">
  <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10">Dashboard Utama</h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item">Dashboard</li>
      </ul>
    </div>
    <?php if ($id_role == 3) { ?>
      <div class="page-header-right ms-auto">
        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
          <a href="transaksi-penjualan/input-penjualan-baru" class="btn btn-primary">
            <i class="feather-shopping-cart me-2"></i>
            <span>Kasir POS</span>
          </a>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="main-content">
    <div class="row">

      <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-4">
              <div class="d-flex gap-4 align-items-center">
                <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                  <i class="feather-dollar-sign"></i>
                </div>
                <div>
                  <div class="fs-4 fw-bold text-dark">Rp <?= number_format((float)$total_pendapatan, 0, ',', '.') ?></div>
                  <h3 class="fs-13 fw-semibold text-muted text-truncate-1-line">Pendapatan (Bulan Ini)</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-4">
              <div class="d-flex gap-4 align-items-center">
                <div class="avatar-text avatar-lg bg-soft-success text-success">
                  <i class="feather-check-circle"></i>
                </div>
                <div>
                  <div class="fs-4 fw-bold text-dark"><span class="counter"><?= $total_pesanan ?></span> Transaksi</div>
                  <h3 class="fs-13 fw-semibold text-muted text-truncate-1-line">Pesanan Selesai</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-4">
              <div class="d-flex gap-4 align-items-center">
                <div class="avatar-text avatar-lg bg-soft-info text-info">
                  <i class="feather-package"></i>
                </div>
                <div>
                  <div class="fs-4 fw-bold text-dark"><span class="counter"><?= $total_barang_terjual ?></span> Item</div>
                  <h3 class="fs-13 fw-semibold text-muted text-truncate-1-line">Barang Terjual</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-md-6">
        <div class="card stretch stretch-full">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-4">
              <div class="d-flex gap-4 align-items-center">
                <div class="avatar-text avatar-lg bg-soft-danger text-danger">
                  <i class="feather-alert-triangle"></i>
                </div>
                <div>
                  <div class="fs-4 fw-bold text-dark"><span class="counter"><?= $jumlah_stok_menipis ?></span> Jenis</div>
                  <h3 class="fs-13 fw-semibold text-muted text-truncate-1-line">Stok Menipis / Habis</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-8 mb-4">
        <div class="card stretch stretch-full border-0 shadow-sm">
          <div class="card-header bg-white border-bottom py-3">
            <h5 class="card-title mb-0 fw-bold">Top 5 Barang Terlaris</h5>
          </div>
          <div class="card-body">
            <div id="bar-chart-terlaris"></div>
          </div>
        </div>
      </div>
      <div class="col-xxl-4 mb-4">
        <div class="card stretch stretch-full border-0 shadow-sm">
          <div class="card-header bg-white border-bottom py-3">
            <h5 class="card-title mb-0 fw-bold">Proporsi Status Pesanan</h5>
          </div>
          <div class="card-body d-flex justify-content-center align-items-center">
            <div id="pie-chart-status"></div>
          </div>
        </div>
      </div>
      <div class="col-xxl-8">
        <div class="card stretch stretch-full">
          <div class="card-header">
            <h5 class="card-title">Transaksi Terbaru</h5>
            <div class="card-header-action">
              <?php if ($id_role <= 2) { ?>
                <a href="manajemen-pesanan/transaksi" class="btn btn-sm btn-light">Lihat Semua</a>
              <?php } else if ($id_role == 3) { ?>
                <a href="transaksi-penjualan/daftar-transaksi" class="btn btn-sm btn-light">Lihat Semua</a>
              <?php } ?>
            </div>
          </div>
          <div class="card-body custom-card-action p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr class="border-b">
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Kasir/Pelanggan</th>
                    <th>Status</th>
                    <th class="text-end">Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (mysqli_num_rows($transaksi_terbaru) > 0) {
                    while ($trx = mysqli_fetch_assoc($transaksi_terbaru)) {
                  ?>
                      <tr>
                        <td class="fw-bold text-primary">ORD-<?= str_pad($trx['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td><?= date('d M Y, H:i', strtotime($trx['tanggal_pesan'])) ?></td>
                        <td><?= htmlspecialchars($trx['nama_kasir'] ?? 'Pelanggan Walk-in') ?></td>
                        <td>
                          <?php
                          $status_bg = 'bg-soft-warning text-warning';
                          if ($trx['status_pesanan'] == 'Selesai') $status_bg = 'bg-soft-success text-success';
                          else if ($trx['status_pesanan'] == 'Batal') $status_bg = 'bg-soft-danger text-danger';
                          else if ($trx['status_pesanan'] == 'Diproses') $status_bg = 'bg-soft-info text-info';
                          ?>
                          <span class="badge <?= $status_bg ?>"><?= $trx['status_pesanan'] ?></span>
                        </td>
                        <td class="text-end fw-bold">Rp <?= number_format((float)$trx['grand_total'], 0, ',', '.') ?></td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-4">
        <div class="card stretch stretch-full">
          <div class="card-header">
            <h5 class="card-title text-danger"><i class="feather-alert-octagon me-2"></i>Peringatan Stok</h5>
          </div>
          <div class="card-body">
            <?php if (mysqli_num_rows($stok_menipis) > 0) {
              while ($stok = mysqli_fetch_assoc($stok_menipis)) {
                $bg_color = ($stok['stok_tersedia'] == 0) ? 'bg-danger' : 'bg-warning';
                $text_color = ($stok['stok_tersedia'] == 0) ? 'text-danger' : 'text-warning';
            ?>
                <div class="p-3 border border-dashed rounded-3 mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                      <div class="wd-50 ht-50 bg-soft-danger <?= $text_color ?> lh-1 d-flex align-items-center justify-content-center flex-column rounded-2">
                        <i class="feather-box fs-4"></i>
                      </div>
                      <div class="text-dark">
                        <div class="fw-bold mb-1 text-truncate-1-line"><?= $stok['nama_barang'] ?></div>
                        <span class="fs-12 fw-normal text-muted">Butuh Restock segera!</span>
                      </div>
                    </div>
                    <div class="text-end">
                      <span class="badge <?= $bg_color ?> fs-12"><?= $stok['stok_tersedia'] ?> <?= $stok['satuan'] ?></span>
                    </div>
                  </div>
                </div>
              <?php }
            } else { ?>
              <div class="text-center py-5 text-muted">
                <i class="feather-check-circle fs-1 text-success d-block mb-2"></i>
                Stok semua barang aman!
              </div>
            <?php } ?>
          </div>
          <?php if ($id_role <= 2) {  ?>
            <a href="katalog/inventori-stok" class="card-footer fs-12 fw-bold text-uppercase text-center">Kelola Inventori</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once("../templates/views_bottom.php") ?>

<script>
  window.addEventListener("load", function() {

    // Pastikan library bawaan (ApexCharts) benar-benar terdeteksi
    if (typeof ApexCharts !== 'undefined') {

      // ==========================================
      // 1. RENDER BAR CHART (BARANG TERLARIS)
      // ==========================================
      var barLabels = <?php echo json_encode($bar_labels); ?>;
      var barData = <?php echo json_encode($bar_data); ?>;

      var optionsBar = {
        series: [{
          name: 'Total Terjual (Item)',
          data: barData
        }],
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
            colors: {
              ranges: [{
                from: 0,
                to: 100000,
                color: '#3454d1' // Sesuaikan warna dengan tema template
              }]
            }
          }
        },
        dataLabels: {
          enabled: true
        },
        xaxis: {
          categories: barLabels,
        },
        tooltip: {
          theme: 'light'
        }
      };

      var chartBar = new ApexCharts(document.querySelector("#bar-chart-terlaris"), optionsBar);
      chartBar.render();


      // ==========================================
      // 2. RENDER PIE CHART (STATUS PESANAN)
      // ==========================================
      var pieLabels = <?php echo json_encode($pie_labels); ?>;
      var pieData = <?php echo json_encode($pie_data); ?>;

      var optionsPie = {
        series: pieData,
        chart: {
          type: 'donut',
          height: 350
        },
        labels: pieLabels,
        colors: ['#28a745', '#ffc107', '#dc3545', '#17a2b8'],
        plotOptions: {
          pie: {
            donut: {
              size: '65%',
              labels: {
                show: true,
                name: {
                  show: true
                },
                value: {
                  show: true
                }
              }
            }
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val.toFixed(1) + "%"
          }
        },
        legend: {
          position: 'bottom'
        }
      };

      var chartPie = new ApexCharts(document.querySelector("#pie-chart-status"), optionsPie);
      chartPie.render();

    } else {
      console.error("Library ApexCharts tidak ditemukan. Pastikan template ini menggunakan ApexCharts.");
    }
  });
</script>