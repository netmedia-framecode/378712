<?php require_once("../../controller/user-management.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Pelanggan";
require_once("../../templates/views_top.php"); ?>

<div class="nxl-content">

  <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION['project_si_penjualan_bahan_bangunan']['name_page'] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">User Management</li>
        <li class="breadcrumb-item"><?= $_SESSION['project_si_penjualan_bahan_bangunan']['name_page'] ?></li>
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
                    <th class="text-center">Nama</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">No. Telepon</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($views_pelanggan as $key => $data) { ?>
                    <tr class="single-item">
                      <td class="text-center"><?= $key + 1 ?></td>
                      <td><?= $data['name'] ?></td>
                      <td><?= $data['email'] ?></td>
                      <td><?= !empty($data['nomor_telepon']) ? $data['nomor_telepon'] : '<span class="text-muted">Belum diisi</span>' ?></td>
                      <td><?= !empty($data['alamat']) ? $data['alamat'] : '<span class="text-muted">Belum diisi</span>' ?></td>
                      <td class="text-center">
                        <span class="badge <?= ($data['status'] == 'Active') ? 'bg-success' : 'bg-danger' ?>">
                          <?= $data['status'] ?>
                        </span>
                      </td>
                      <td>
                        <div class="hstack gap-2 justify-content-center">
                          <a href="edit-pelanggan?p=<?= $data['id_user'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                          </a>
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