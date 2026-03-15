<?php require_once("../../controller/manajemen-pesanan.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Pesanan";
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
                    <th class="text-center">Tanggal Pesan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($views_pesanan as $key => $data) { ?>
                    <tr class="single-item">
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td class="text-center">
                        <span class="badge bg-light text-dark border">ORD-<?= str_pad($data['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></span>
                      </td>
                      <td><?= $data['name'] ?></td>
                      <td class="text-center"><?= date('d M Y, H:i', strtotime($data['tanggal_pesan'])) ?></td>
                      <td class="text-center">
                        <?php
                        // Logika warna badge berdasarkan status pesanan
                        $status_bg = 'bg-secondary';
                        if ($data['status_pesanan'] == 'Menunggu Konfirmasi') $status_bg = 'bg-warning text-dark';
                        else if ($data['status_pesanan'] == 'Diproses') $status_bg = 'bg-info text-dark';
                        else if ($data['status_pesanan'] == 'Selesai') $status_bg = 'bg-success';
                        else if ($data['status_pesanan'] == 'Batal') $status_bg = 'bg-danger';
                        ?>
                        <span class="badge <?= $status_bg ?>"><?= $data['status_pesanan'] ?></span>
                      </td>
                      <td>
                        <div class="hstack gap-2 justify-content-center">
                          <a href="edit-pesanan?p=<?= $data['id_pesanan'] ?>" class="btn btn-warning btn-sm" title="Ubah Status/Lihat Detail">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <form action="" method="POST" class="d-inline">
                            <input type="hidden" name="id_pesanan" value="<?= $data['id_pesanan'] ?>">
                            <button type="submit" name="delete_pesanan" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data pesanan ini? Semua detail transaksi di dalamnya juga akan terhapus.');" title="Hapus">
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