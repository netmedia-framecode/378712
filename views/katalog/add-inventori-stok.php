<?php require_once("../../controller/katalog.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Tambah Inventori Stok";
require_once("../../templates/views_top.php");

// Menarik data katalog yang belum masuk ke tabel inventori
// Kamu bisa memindahkan query ini ke controller katalog.php jika ingin lebih rapi
$query_barang_baru = "SELECT kode_katalog, nama_barang, satuan 
                      FROM tabel_katalog 
                      WHERE kode_katalog NOT IN (SELECT kode_katalog FROM tabel_inventori)
                      ORDER BY nama_barang ASC";
$barang_baru = mysqli_query($conn, $query_barang_baru);
?>

<div class="nxl-content" style="height: 100vh;">

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

            <?php if (mysqli_num_rows($barang_baru) == 0): ?>
              <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                Semua barang dari Master Katalog sudah memiliki data stok. <br>
                Silakan gunakan fitur <strong>Ubah</strong> di halaman Inventori Stok untuk memperbarui jumlahnya.
              </div>
              <div class="text-center mt-3">
                <a href="inventori-stok" class="btn btn-secondary">Kembali ke Inventori</a>
              </div>
            <?php else: ?>
              <form action="" method="POST">

                <div class="mb-4">
                  <label for="kode_katalog" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                  <select class="form-select" id="kode_katalog" name="kode_katalog" required>
                    <option value="" selected disabled>-- Pilih Barang dari Katalog --</option>
                    <?php while ($row = mysqli_fetch_assoc($barang_baru)): ?>
                      <option value="<?= $row['kode_katalog'] ?>">
                        <?= $row['kode_katalog'] ?> - <?= $row['nama_barang'] ?> (<?= $row['satuan'] ?>)
                      </option>
                    <?php endwhile; ?>
                  </select>
                  <small class="text-muted">Hanya menampilkan barang yang belum ada di inventori stok.</small>
                </div>

                <div class="mb-4">
                  <label for="stok_tersedia" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="stok_tersedia" name="stok_tersedia" min="0" placeholder="Masukkan jumlah stok awal..." required>
                </div>

                <div class="d-flex justify-content-start gap-2">
                  <a href="inventori-stok" class="btn btn-secondary">Batal</a>
                  <button type="submit" name="add_inventori" class="btn btn-primary">Simpan Stok</button>
                </div>

              </form>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once("../../templates/views_bottom.php") ?>