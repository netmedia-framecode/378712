<?php require_once("../../controller/user-management.php");
if (!isset($_GET["p"])) {
  header("Location: pelanggan"); // Arahkan kembali ke halaman list pelanggan
  exit();
} else {
  $id = valid($conn, $_GET["p"]); // Diasumsikan $_GET["p"] membawa id_user

  // Menggunakan LEFT JOIN agar data tetap tampil meski tabel_pelanggan masih kosong
  $pull_data = "SELECT 
                  users.id_user, 
                  users.name, 
                  users.email, 
                  users.id_active,
                  tabel_pelanggan.id_pelanggan, 
                  tabel_pelanggan.alamat, 
                  tabel_pelanggan.nomor_telepon 
                FROM users 
                LEFT JOIN tabel_pelanggan ON users.id_user = tabel_pelanggan.id_user 
                WHERE users.id_user = '$id'";

  $store_data = mysqli_query($conn, $pull_data);
  $view_data = mysqli_fetch_assoc($store_data);

  $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Ubah Pelanggan";
  require_once("../../templates/views_top.php"); ?>

  <div class="nxl-content" style="height: 100vh;">

    <div class="page-header">
      <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
          <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
        </div>
        <ul class="breadcrumb">
          <li class="breadcrumb-item">Pelanggan</li>
          <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] . ' - ' . htmlspecialchars($view_data["name"] ?? '')  ?></li>
        </ul>
      </div>
    </div>
    <div class="main-content">
      <div class="row">
        <div class="col-lg-6">
          <div class="card stretch stretch-full">
            <div class="card-body">
              <form action="" method="POST">

                <input type="hidden" name="id_user" value="<?= $view_data['id_user'] ?>">
                <input type="hidden" name="id_pelanggan" value="<?= $view_data['id_pelanggan'] ?? '' ?>">

                <div class="mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($view_data['name'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($view_data['email'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                  <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                  <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= htmlspecialchars($view_data['nomor_telepon'] ?? '') ?>" placeholder="Contoh: 081234567890">
                </div>

                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat Lengkap</label>
                  <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= htmlspecialchars($view_data['alamat'] ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                  <label for="id_active" class="form-label">Status Akun</label>
                  <select class="form-select" id="id_active" name="id_active" required>
                    <option value="1" <?= ($view_data['id_active'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="2" <?= ($view_data['id_active'] == 2) ? 'selected' : '' ?>>No Active</option>
                  </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                  <a href="pelanggan" class="btn btn-secondary">Batal</a>
                  <button type="submit" name="edit_pelanggan" class="btn btn-primary">Simpan Perubahan</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php }
require_once("../../templates/views_bottom.php") ?>