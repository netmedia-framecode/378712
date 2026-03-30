<?php require_once("../../controller/katalog.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Inventori Stok";
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
    <div class="page-header-right ms-auto">
      <div class="page-header-right-items">
        <div class="d-flex d-md-none">
          <a href="javascript:void(0)" class="page-header-right-close-toggle">
            <i class="feather-arrow-left me-2"></i>
            <span>Back</span>
          </a>
        </div>
        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
          <a href="add-inventori-stok" class="btn btn-primary">
            <i class="feather-plus me-2"></i>
            <span>Tambah</span>
          </a>
        </div>
      </div>
      <div class="d-md-none d-flex align-items-center">
        <a href="javascript:void(0)" class="page-header-right-open-toggle">
          <i class="feather-align-right fs-20"></i>
        </a>
      </div>
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
                    <th class="text-center">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Stok Tersedia</th>
                    <th class="text-center">Terakhir Diupdate</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($views_inventori as $key => $data) { ?>
                    <tr class="single-item">
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td class="text-center">
                        <span class="badge bg-light text-dark border"><?= $data['kode_katalog'] ?></span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0">
                            <?php
                            $gambar = (!empty($data['gambar_barang'])) ? $data['gambar_barang'] : 'default.png';
                            ?>
                            <img src="../../assets/img/katalog/<?= htmlspecialchars($gambar) ?>"
                              alt="Gambar Barang"
                              class="rounded border"
                              style="width: 45px; height: 45px; object-fit: cover;">
                          </div>

                          <div>
                            <span class="d-block fw-bold text-dark"><?= htmlspecialchars($data['nama_barang']) ?></span>
                          </div>
                        </div>
                      </td>
                      <td class="text-center"><?= $data['satuan'] ?></td>
                      <td class="text-center">
                        <?php
                        // Logika warna badge stok
                        $badge_color = 'bg-danger'; // Default merah (0)
                        if ($data['stok_tersedia'] > 10) {
                          $badge_color = 'bg-success'; // Hijau jika stok aman (>10)
                        } elseif ($data['stok_tersedia'] > 0 && $data['stok_tersedia'] <= 10) {
                          $badge_color = 'bg-warning text-dark'; // Kuning jika stok menipis (1-10)
                        }
                        ?>
                        <span class="badge <?= $badge_color ?>">
                          <?= $data['stok_tersedia'] ?>
                        </span>
                      </td>
                      <td class="text-center"><?= date('d M Y, H:i', strtotime($data['terakhir_diupdate'])) ?></td>
                      <td>
                        <div class="hstack gap-2 justify-content-center">
                          <a href="edit-inventori-stok?p=<?= $data['id_inventori'] ?>" class="btn btn-warning btn-sm" title="Ubah Stok">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <form action="" method="POST" class="d-inline">
                            <input type="hidden" name="id_inventori" value="<?= $data['id_inventori'] ?>">
                            <button type="submit" name="delete_inventori" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data stok ini?');" title="Hapus">
                              <i class="bi bi-trash"></i>
                            </button>
                          </form>
                        </div>
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