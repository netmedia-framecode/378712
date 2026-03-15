<?php
require_once("../../controller/transaksi-penjualan.php");

if (!isset($_GET["p"])) {
  header("Location: daftar-transaksi");
  exit();
}

$id_pesanan = valid($conn, $_GET["p"]);

// 1. Ambil Data Master Pesanan & Kasir
$query_pesanan = "SELECT 
                    tabel_pesanan.id_pesanan, 
                    tabel_pesanan.tanggal_pesan,
                    users.name AS nama_kasir
                  FROM tabel_pesanan 
                  JOIN users ON tabel_pesanan.id_user = users.id_user 
                  WHERE tabel_pesanan.id_pesanan = '$id_pesanan'";
$result_pesanan = mysqli_query($conn, $query_pesanan);
$data_pesanan = mysqli_fetch_assoc($result_pesanan);

if (!$data_pesanan) {
  die("Data transaksi tidak ditemukan.");
}

// 2. Ambil Rincian Barang yang Dibeli
$query_detail = "SELECT 
                  tabel_transaksi.jumlah_barang, 
                  tabel_transaksi.total_harga,
                  tabel_katalog.nama_barang,
                  tabel_katalog.harga_barang
                 FROM tabel_transaksi 
                 JOIN tabel_katalog ON tabel_transaksi.kode_katalog = tabel_katalog.kode_katalog 
                 WHERE tabel_transaksi.id_pesanan = '$id_pesanan'";
$result_detail = mysqli_query($conn, $query_detail);

$grand_total = 0;

$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Detail Transaksi Kasir";
require_once("../../templates/views_top.php");
?>

<div class="nxl-content">

  <div class="page-header d-print-none">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Kasir</li>
        <li class="breadcrumb-item">Struk Pembayaran</li>
      </ul>
    </div>
  </div>
  <div class="main-content d-flex justify-content-center">

    <div class="row w-100 justify-content-center">
      <div class="col-lg-5 col-md-8 mb-4">
        <div class="card shadow-sm border-0" id="area-struk">
          <div class="card-body p-4" style="font-family: 'Courier New', Courier, monospace; color: #000;">

            <div class="text-center mb-3">
              <h4 class="fw-bold mb-1" style="color: #000;">TOKO GUNUNG MAS INDAH</h4>
              <p class="mb-0" style="font-size: 14px;">Jl. Contoh Alamat Toko No. 123<br>Telp: 0812-3456-7890</p>
            </div>

            <div style="border-bottom: 2px dashed #000; margin-bottom: 10px;"></div>

            <div style="font-size: 14px; margin-bottom: 10px;">
              <div class="d-flex justify-content-between">
                <span>Tgl : <?= date('d/m/Y H:i', strtotime($data_pesanan['tanggal_pesan'])) ?></span>
                <span>Ksr : <?= htmlspecialchars($data_pesanan['nama_kasir']) ?></span>
              </div>
              <div class="d-flex justify-content-between">
                <span>No : ORD-<?= str_pad($data_pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></span>
              </div>
            </div>

            <div style="border-bottom: 2px dashed #000; margin-bottom: 10px;"></div>

            <div style="font-size: 14px;">
              <?php
              while ($item = mysqli_fetch_assoc($result_detail)) {
                $grand_total += $item['total_harga'];
              ?>
                <div class="mb-2">
                  <div class="fw-bold"><?= $item['nama_barang'] ?></div>
                  <div class="d-flex justify-content-between">
                    <span><?= $item['jumlah_barang'] ?> x <?= number_format($item['harga_barang'], 0, ',', '.') ?></span>
                    <span><?= number_format($item['total_harga'], 0, ',', '.') ?></span>
                  </div>
                </div>
              <?php } ?>
            </div>

            <div style="border-bottom: 2px dashed #000; margin-bottom: 10px; margin-top: 10px;"></div>

            <div class="d-flex justify-content-between fw-bold fs-5 mb-3" style="font-size: 16px;">
              <span>TOTAL :</span>
              <span>Rp <?= number_format($grand_total, 0, ',', '.') ?></span>
            </div>

            <div style="border-bottom: 2px dashed #000; margin-bottom: 15px;"></div>

            <div class="text-center" style="font-size: 13px;">
              <p class="mb-1">Terima kasih atas kunjungan Anda!</p>
              <p class="mb-0">Barang yang sudah dibeli<br>tidak dapat dikembalikan.</p>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 d-print-none">
        <div class="card shadow-sm border-0 sticky-top" style="top: 80px;">
          <div class="card-body">
            <h6 class="fw-bold mb-3">Tindakan</h6>
            <div class="d-grid gap-2">
              <button onclick="cetakStruk()" class="btn btn-primary btn-lg fw-bold shadow-sm">
                <i class="bi bi-printer me-2"></i> Cetak Struk
              </button>
              <a href="input-penjualan-baru" class="btn btn-outline-success fw-bold">
                <i class="bi bi-plus-circle me-2"></i> Transaksi Baru
              </a>
              <a href="daftar-transaksi" class="btn btn-light fw-bold">
                Kembali ke Riwayat
              </a>
            </div>

            <div class="alert alert-info mt-4" style="font-size: 13px;">
              <i class="bi bi-info-circle me-1"></i>
              Gunakan kertas thermal ukuran <strong>58mm</strong> atau <strong>80mm</strong> pada pengaturan printer Anda untuk hasil cetak yang maksimal.
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  /* Styling khusus saat mode print diaktifkan */
  @media print {
    body * {
      visibility: hidden;
    }

    /* Hanya area struk yang terlihat */
    #area-struk,
    #area-struk * {
      visibility: visible;
    }

    #area-struk {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      /* Lebar akan menyesuaikan dengan kertas printer thermal */
      margin: 0;
      padding: 0;
      box-shadow: none !important;
    }

    .card-body {
      padding: 0 !important;
    }

    /* Sembunyikan elemen dashboard yang tidak perlu */
    .d-print-none {
      display: none !important;
    }
  }
</style>

<script>
  function cetakStruk() {
    window.print();
  }
</script>

<?php require_once("../../templates/views_bottom.php") ?>