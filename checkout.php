<?php
require_once("controller/visitor.php");

// Proteksi Halaman
if (!isset($_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["id"]) || empty($_SESSION['keranjang'])) {
  header("Location: keranjang");
  exit();
}

$id_user = $_SESSION["project_si_penjualan_bahan_bangunan"]["users"]["id"];

// Cek Kelengkapan Data Pelanggan di Database
$query_pelanggan = mysqli_query($conn, "SELECT nomor_telepon, alamat FROM tabel_pelanggan WHERE id_user = '$id_user'");
$data_pelanggan = mysqli_fetch_assoc($query_pelanggan);

$no_telp = $data_pelanggan['no_telp'] ?? '';
$alamat = $data_pelanggan['alamat'] ?? '';

// Status true jika nomor HP dan alamat sudah terisi
$data_lengkap = (!empty($no_telp) && !empty($alamat));

$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Checkout";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");

$total_belanja = 0;
?>

<main class="flex-grow bg-gray-50 pb-16">

  <div class="bg-primary text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold">Penyelesaian Pesanan</h1>
      <p class="text-blue-100 mt-2">Satu langkah lagi untuk menyelesaikan proyek Anda.</p>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

      <div class="lg:col-span-2 space-y-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
          <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-geo-alt text-primary"></i> Detail Pengiriman
          </h2>

          <div id="area-form-pelanggan" class="<?= $data_lengkap ? 'hidden' : '' ?>">
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg text-sm mb-6 flex items-start gap-3">
              <i class="bi bi-info-circle-fill text-lg mt-0.5"></i>
              <p>Mohon lengkapi <strong>Nomor Telepon/WhatsApp</strong> dan <strong>Alamat Lengkap</strong> Anda agar kami dapat memproses dan mengirimkan pesanan ke lokasi yang tepat.</p>
            </div>

            <form id="form-update-data" class="space-y-5">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" id="input_telp" value="<?= htmlspecialchars($no_telp) ?>" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition" placeholder="Contoh: 081234567890">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Proyek / Rumah <span class="text-red-500">*</span></label>
                <textarea id="input_alamat" rows="3" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition resize-none" placeholder="Contoh: Jl. Merdeka No. 45, RT 01/RW 02. Patokan: Depan masjid..."><?= htmlspecialchars($alamat) ?></textarea>
              </div>

              <div class="flex items-center gap-4 pt-2">
                <button type="submit" id="btn-simpan-data" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300">
                  Simpan Alamat
                </button>
                <span id="pesan-update" class="text-sm font-semibold hidden"></span>
              </div>
            </form>
          </div>

          <div id="area-data-tersimpan" class="<?= $data_lengkap ? '' : 'hidden' ?> bg-blue-50/50 p-6 rounded-xl border border-blue-100">
            <div class="flex justify-between items-start mb-4">
              <div>
                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Penerima</p>
                <p class="font-bold text-gray-900 text-lg"><?= $_SESSION['name'] ?? 'Pelanggan' ?></p>
              </div>
              <button type="button" id="btn-edit-data" class="text-sm font-semibold text-primary hover:text-blue-800 bg-white px-3 py-1.5 rounded-md border border-blue-200 shadow-sm transition">
                <i class="bi bi-pencil-square me-1"></i> Ubah
              </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-500 mb-1">Nomor Kontak:</p>
                <p id="display_telp" class="font-medium text-gray-800"><?= htmlspecialchars($no_telp) ?></p>
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Alamat Pengiriman:</p>
                <p id="display_alamat" class="font-medium text-gray-800 leading-relaxed"><?= nl2br(htmlspecialchars($alamat)) ?></p>
              </div>
            </div>
          </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
          <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-wallet2 text-primary"></i> Metode Pembayaran
          </h2>
          <label class="flex items-center p-4 border rounded-xl border-primary bg-blue-50">
            <input type="radio" checked disabled class="w-5 h-5 text-primary">
            <div class="ml-4">
              <span class="block font-semibold text-gray-900">Bayar di Tempat (COD)</span>
              <span class="block text-sm text-gray-500">Pembayaran tunai dilakukan langsung kepada sopir/kurir kami saat material tiba di lokasi Anda.</span>
            </div>
          </label>
        </div>

      </div>

      <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
          <h2 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Pesanan Anda</h2>

          <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2">
            <?php
            foreach ($_SESSION['keranjang'] as $kode => $qty) {
              $query_item = mysqli_query($conn, "SELECT nama_barang, harga_barang FROM tabel_katalog WHERE kode_katalog = '$kode'");
              $item = mysqli_fetch_assoc($query_item);
              $subtotal = $item['harga_barang'] * $qty;
              $total_belanja += $subtotal;
            ?>
              <div class="flex justify-between items-start">
                <div>
                  <h4 class="text-sm font-semibold text-gray-800 line-clamp-1" title="<?= htmlspecialchars($item['nama_barang']) ?>"><?= htmlspecialchars($item['nama_barang']) ?></h4>
                  <span class="text-xs text-gray-500"><?= $qty ?> x Rp <?= number_format($item['harga_barang'], 0, ',', '.') ?></span>
                </div>
                <span class="text-sm font-bold text-gray-900 whitespace-nowrap ml-2">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
              </div>
            <?php } ?>
          </div>

          <hr class="border-gray-100 mb-4">

          <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600 text-sm">Subtotal Produk</span>
            <span class="font-semibold text-gray-900">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
          </div>
          <div class="flex justify-between items-center mb-4">
            <span class="text-gray-600 text-sm">Ongkos Kirim</span>
            <span class="font-semibold text-green-500 text-sm">Gratis (Promo)</span>
          </div>

          <div class="bg-blue-50 p-4 rounded-xl flex justify-between items-center mb-6">
            <span class="font-bold text-gray-900">Total Bayar</span>
            <span class="font-extrabold text-xl text-primary">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
          </div>

          <div id="btn-kunci" class="<?= $data_lengkap ? 'hidden' : '' ?>">
            <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3.5 rounded-xl shadow-sm cursor-not-allowed flex justify-center items-center gap-2">
              <i class="bi bi-lock-fill"></i> Lengkapi Alamat Dahulu
            </button>
          </div>

          <div id="btn-buka" class="<?= $data_lengkap ? '' : 'hidden' ?>">
            <form action="" method="POST">
              <button type="submit" name="proses_checkout" onclick="return confirm('Apakah Anda yakin data alamat dan pesanan sudah benar?')" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl shadow-md transition duration-300 flex justify-center items-center gap-2">
                <i class="bi bi-shield-check"></i> Buat Pesanan Sekarang
              </button>
            </form>
          </div>

          <p class="text-xs text-center text-gray-400 mt-4">
            Dengan menekan tombol ini, Anda menyetujui syarat dan ketentuan Toko Sumber Logam.
          </p>
        </div>
      </div>

    </div>
  </div>

</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
  $(document).ready(function() {

    // Saat tombol EDIT diklik
    $('#btn-edit-data').on('click', function() {
      $('#area-data-tersimpan').slideUp();
      $('#area-form-pelanggan').slideDown();

      // Kunci kembali tombol checkout saat mode edit
      $('#btn-buka').hide();
      $('#btn-kunci').fadeIn();
    });

    // Saat form pengisian alamat di-submit
    $('#form-update-data').on('submit', function(e) {
      e.preventDefault();

      let btn = $('#btn-simpan-data');
      let msg = $('#pesan-update');
      let originalText = btn.html();

      btn.html('<i class="bi bi-arrow-repeat animate-spin"></i> Menyimpan...').prop('disabled', true);
      msg.hide().removeClass('text-green-500 text-red-500');

      $.ajax({
        url: 'controller/update_pelanggan_ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'update_pelanggan',
          no_telp: $('#input_telp').val(),
          alamat: $('#input_alamat').val()
        },
        success: function(res) {
          if (res.status === 'success') {
            // Tampilkan pesan sukses
            msg.html('<i class="bi bi-check-circle"></i> ' + res.message).addClass('text-green-500').fadeIn();

            setTimeout(function() {
              // 1. Update teks di tampilan display
              $('#display_telp').text(res.no_telp);
              $('#display_alamat').text(res.alamat); // Bisa ditambah .replace(/\n/g, '<br>') jika ingin baris baru terbaca

              // 2. Sembunyikan form dan munculkan data
              $('#area-form-pelanggan').slideUp();
              $('#area-data-tersimpan').slideDown();

              // 3. BUKA KUNCI TOMBOL CHECKOUT
              $('#btn-kunci').hide();
              $('#btn-buka').fadeIn();

              // Reset tombol form
              btn.html(originalText).prop('disabled', false);
              msg.hide();
            }, 1200);
          } else {
            msg.html('<i class="bi bi-x-circle"></i> ' + res.message).addClass('text-red-500').fadeIn();
            btn.html(originalText).prop('disabled', false);
          }
        },
        error: function() {
          msg.html('<i class="bi bi-exclamation-triangle"></i> Gagal terhubung ke server.').addClass('text-red-500').fadeIn();
          btn.html(originalText).prop('disabled', false);
        }
      });
    });
  });
</script>

<?php require_once("sections/front_footer.php"); ?>