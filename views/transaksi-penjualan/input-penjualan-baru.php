<?php require_once("../../controller/transaksi-penjualan.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Input Penjualan Baru";
require_once("../../templates/views_top.php"); ?>

<div class="nxl-content">

  <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
      <div class="page-header-title">
        <h5 class="m-b-10"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></h5>
      </div>
      <ul class="breadcrumb">
        <li class="breadcrumb-item">Kasir</li>
        <li class="breadcrumb-item"><?= $_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] ?></li>
      </ul>
    </div>
  </div>
  <div class="main-content">
    <form action="" method="POST" id="form-penjualan">
      <div class="row">

        <div class="col-lg-7 mb-4">
          <div class="card stretch stretch-full border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
              <h5 class="card-title mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Daftar Barang</h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light sticky-top">
                    <tr>
                      <th class="text-center" width="5%">Pilih</th>
                      <th>Detail Barang</th>
                      <th class="text-end" width="20%">Harga</th>
                      <th class="text-center" width="10%">Stok</th>
                      <th class="text-center" width="15%">Jumlah (Qty)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($views_barang) && mysqli_num_rows($views_barang) > 0) {
                      while ($data = mysqli_fetch_assoc($views_barang)) {
                    ?>
                        <tr>
                          <td class="text-center">
                            <div class="form-check d-flex justify-content-center">
                              <input class="form-check-input check-barang" type="checkbox"
                                name="kode_katalog_pilih[]"
                                value="<?= $data['kode_katalog'] ?>"
                                id="check_<?= $data['kode_katalog'] ?>"
                                data-nama="<?= htmlspecialchars($data['nama_barang']) ?>"
                                data-harga="<?= $data['harga_barang'] ?>"
                                onchange="toggleQty('<?= $data['kode_katalog'] ?>'); updateCart();">
                            </div>
                          </td>
                          <td>
                            <label class="form-check-label fw-bold d-block text-primary" for="check_<?= $data['kode_katalog'] ?>" style="cursor: pointer;">
                              <?= $data['nama_barang'] ?>
                            </label>
                            <small class="text-muted"><?= $data['kode_katalog'] ?></small>
                          </td>
                          <td class="text-end fw-semibold text-success">
                            Rp <?= number_format($data['harga_barang'], 0, ',', '.') ?>
                          </td>
                          <td class="text-center">
                            <span class="badge bg-secondary-subtle text-secondary"><?= $data['stok_tersedia'] ?> <?= $data['satuan'] ?></span>
                          </td>
                          <td class="text-center">
                            <input type="number" name="qty[<?= $data['kode_katalog'] ?>]"
                              id="qty_<?= $data['kode_katalog'] ?>"
                              class="form-control text-center bg-white"
                              min="1" max="<?= $data['stok_tersedia'] ?>"
                              placeholder="0" disabled required
                              oninput="updateCart();">
                          </td>
                        </tr>
                    <?php
                      }
                    } else {
                      echo '<tr><td colspan="5" class="text-center text-muted py-4">Tidak ada barang yang tersedia atau stok habis.</td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card stretch stretch-full border-0 shadow-sm sticky-top" style="top: 80px; z-index: 1;">
            <div class="card-header bg-primary text-white py-3">
              <h5 class="card-title mb-0 fw-bold text-white"><i class="bi bi-receipt me-2"></i>Ringkasan Transaksi</h5>
            </div>
            <div class="card-body d-flex flex-column">

              <div class="cart-container mb-3 flex-grow-1" style="max-height: 250px; overflow-y: auto;">
                <ul class="list-group list-group-flush" id="cart-list">
                  <li class="list-group-item text-center text-muted py-4" id="empty-cart-msg">
                    <i class="bi bi-cart-x fs-2 d-block mb-2 opacity-50"></i>
                    Belum ada barang dipilih
                  </li>
                </ul>
              </div>

              <div class="bg-light p-3 rounded mb-4">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="fw-bold text-muted fs-5">TOTAL</span>
                  <h3 class="fw-bold text-success mb-0" id="grand-total">Rp 0</h3>
                </div>
              </div>

              <hr class="mt-0">

              <h6 class="fw-bold mb-3 text-dark">Data Pelanggan (Walk-in)</h6>
              <div class="mb-3">
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Pembeli (Opsional)">
              </div>
              <div class="mb-4">
                <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Catatan Tambahan (Opsional)..."></textarea>
              </div>

              <div class="d-grid gap-2 mt-auto">
                <button type="submit" name="proses_penjualan" class="btn btn-primary btn-lg fw-bold shadow-sm" id="btn-proses" disabled>
                  <i class="bi bi-cart-check me-2"></i> Proses Pembayaran
                </button>
                <a href="transaksi" class="btn btn-light fw-semibold">Batal</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
  // Fungsi format Rupiah (misal: 10000 -> 10.000)
  function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  // Mengaktifkan/menonaktifkan input Qty
  function toggleQty(kodeKatalog) {
    const checkBox = document.getElementById('check_' + kodeKatalog);
    const qtyInput = document.getElementById('qty_' + kodeKatalog);

    if (checkBox.checked) {
      qtyInput.disabled = false;
      if (qtyInput.value === "" || qtyInput.value === "0") {
        qtyInput.value = 1; // Default 1
      }
      qtyInput.focus();
    } else {
      qtyInput.disabled = true;
      qtyInput.value = "";
    }
  }

  // Mengupdate daftar keranjang belanja di sebelah kanan
  function updateCart() {
    const checkboxes = document.querySelectorAll('.check-barang:checked');
    const cartList = document.getElementById('cart-list');
    const grandTotalEl = document.getElementById('grand-total');
    const btnProses = document.getElementById('btn-proses');

    let grandTotal = 0;
    let cartHTML = '';

    if (checkboxes.length === 0) {
      // Jika kosong, tampilkan pesan kosong dan matikan tombol proses
      cartHTML = `
        <li class="list-group-item text-center text-muted py-4">
          <i class="bi bi-cart-x fs-2 d-block mb-2 opacity-50"></i>
          Belum ada barang dipilih
        </li>`;
      btnProses.disabled = true;
    } else {
      // Tampilkan list barang
      checkboxes.forEach(cb => {
        const kode = cb.value;
        const nama = cb.getAttribute('data-nama');
        const harga = parseFloat(cb.getAttribute('data-harga'));

        const qtyInput = document.getElementById('qty_' + kode);
        const qty = parseInt(qtyInput.value) || 0;

        if (qty > 0) {
          const subtotal = harga * qty;
          grandTotal += subtotal;

          cartHTML += `
            <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
              <div>
                <h6 class="mb-0 fw-bold">${nama}</h6>
                <small class="text-muted">${qty} x Rp ${formatRupiah(harga)}</small>
              </div>
              <span class="fw-bold text-dark">Rp ${formatRupiah(subtotal)}</span>
            </li>
          `;
        }
      });
      // Aktifkan tombol proses jika ada barang yang valid
      btnProses.disabled = false;
    }

    // Render HTML ke list dan update Total
    cartList.innerHTML = cartHTML;
    grandTotalEl.innerText = 'Rp ' + formatRupiah(grandTotal);
  }
</script>

<?php require_once("../../templates/views_bottom.php") ?>