<?php require_once("../../controller/katalog.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Tambah Daftar Barang";
require_once("../../templates/views_top.php"); ?>

<div class="nxl-content">

  <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Katalog</li>
        <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></li>
      </ul>
    </div>
  </div>
  <div class="main-content">
    <div class="row">
      <div class="col-lg-6">
        <div class="card stretch stretch-full">
          <div class="card-body">
            <form action="" method="POST">

              <div class="mb-3">
                <label for="kode_katalog" class="form-label">Kode Barang <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="kode_katalog" name="kode_katalog" placeholder="Contoh: BRG-001" required>
                <small class="text-muted">Pastikan kode barang unik dan tidak ada spasi.</small>
              </div>

              <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Contoh: Semen Gresik 40kg" required>
              </div>

              <div class="mb-3">
                <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Contoh: Sak, Meter, Pcs, Batang" required>
              </div>

              <div class="mb-3">
                <label for="deskripsi_barang" class="form-label">Deskripsi Barang</label>
                <textarea class="form-control" id="deskripsi_barang" name="deskripsi_barang" rows="3" placeholder="Masukkan detail spesifikasi atau keterangan barang..."></textarea>
              </div>

              <div class="mb-4">
                <label for="harga_barang" class="form-label">Harga Barang (Rp) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="harga_barang" name="harga_barang" min="0" placeholder="Contoh: 55000" required>
              </div>

              <div class="d-flex justify-content-start gap-2">
                <a href="daftar-barang" class="btn btn-secondary">Batal</a>
                <button type="submit" name="add_barang" class="btn btn-primary">Simpan Barang</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once("../../templates/views_bottom.php") ?>