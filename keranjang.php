<?php
require_once("controller/visitor.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Keranjang Belanja";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");

$keranjang_kosong = empty($_SESSION['keranjang']);
$total_belanja = 0;
?>

<main class="flex-grow bg-gray-50 pb-16">

  <div class="bg-primary text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold">Keranjang Belanja</h1>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

    <?php if ($keranjang_kosong) { ?>
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center max-w-2xl mx-auto mt-10">
        <i class="bi bi-cart-x text-6xl text-gray-300 mb-4 block"></i>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h3>
        <p class="text-gray-500 mb-6">Sepertinya Anda belum memilih material bangunan untuk proyek Anda.</p>
        <a href="katalog" class="inline-block bg-primary text-white font-semibold px-8 py-3 rounded-xl hover:bg-blue-700 transition">
          Mulai Belanja
        </a>
      </div>
    <?php } else { ?>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Daftar Material</h2>

          <form action="" method="POST">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="text-sm text-gray-500 uppercase tracking-wider border-b">
                    <th class="pb-3 font-semibold">Produk</th>
                    <th class="pb-3 font-semibold text-center w-24">Jumlah</th>
                    <th class="pb-3 font-semibold text-right">Subtotal</th>
                    <th class="pb-3 font-semibold text-center w-12"></th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <?php
                  // Ambil detail barang dari database berdasarkan session keranjang
                  foreach ($_SESSION['keranjang'] as $kode => $qty) {
                    $query_item = mysqli_query($conn, "SELECT nama_barang, harga_barang, satuan FROM tabel_katalog WHERE kode_katalog = '$kode'");
                    $item = mysqli_fetch_assoc($query_item);
                    $subtotal = $item['harga_barang'] * $qty;
                    $total_belanja += $subtotal;
                  ?>
                    <tr class="hover:bg-gray-50 transition">
                      <td class="py-4 py-4 pr-4">
                        <p class="text-xs text-gray-400 mb-1"><?= $kode ?></p>
                        <p class="font-bold text-gray-900"><?= htmlspecialchars($item['nama_barang']) ?></p>
                        <p class="text-sm text-primary font-semibold mt-1">Rp <?= number_format($item['harga_barang'], 0, ',', '.') ?> / <?= $item['satuan'] ?></p>
                      </td>
                      <td class="py-4 text-center">
                        <input type="number" name="qty[<?= $kode ?>]" value="<?= $qty ?>" min="1" class="w-16 text-center border border-gray-300 rounded-md py-1 focus:ring-primary focus:border-primary outline-none">
                      </td>
                      <td class="py-4 text-right font-bold text-gray-900">
                        Rp <?= number_format($subtotal, 0, ',', '.') ?>
                      </td>
                      <td class="py-4 text-center">
                        <a href="?hapus_keranjang=<?= $kode ?>" class="text-red-400 hover:text-red-600 transition" title="Hapus">
                          <i class="bi bi-trash text-lg"></i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="mt-6 flex justify-between items-center border-t pt-6">
              <a href="katalog" class="text-primary hover:text-blue-800 font-semibold text-sm">
                <i class="bi bi-arrow-left me-1"></i> Tambah Barang Lain
              </a>
              <button type="submit" name="update_cart" class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg font-semibold text-sm transition">
                <i class="bi bi-arrow-clockwise me-1"></i> Perbarui Keranjang
              </button>
            </div>
          </form>
        </div>

        <div class="lg:col-span-1 space-y-6">

          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Belanja</h2>
            <div class="flex justify-between items-center mb-4">
              <span class="text-gray-600">Total Harga</span>
              <span class="font-bold text-xl text-primary">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
            </div>
            <hr class="border-gray-100 mb-6">

            <div id="area-checkout" class="<?= isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id']) ? '' : 'hidden' ?>">
              <p class="text-sm text-gray-500 mb-4">Pesanan Anda akan diproses setelah Anda menekan tombol checkout di bawah ini.</p>
              <form action="checkout.php" method="POST">
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition shadow-md flex justify-center items-center gap-2">
                  Lanjut Pembayaran <i class="bi bi-check-circle"></i>
                </button>
              </form>
            </div>

            <div id="area-peringatan" class="<?= isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id']) ? 'hidden' : '' ?>">
              <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg text-sm">
                <i class="bi bi-info-circle-fill me-1"></i> Anda harus mendaftar atau login untuk melakukan pembayaran.
              </div>
            </div>
          </div>

          <div id="box-register" class="bg-gradient-to-br from-gray-900 to-blue-900 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden <?= isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id']) ? 'hidden' : '' ?>">
            <i class="bi bi-person-plus absolute -right-6 -top-6 text-9xl opacity-10"></i>
            <div class="relative z-10">
              <h3 class="text-xl font-bold mb-2 text-yellow-400">Belum Punya Akun?</h3>
              <p class="text-sm text-gray-300 mb-5">Daftar sekarang untuk menyelesaikan pesanan Anda.</p>

              <form id="form-register-cepat" class="space-y-3">
                <input type="text" id="reg_name" placeholder="Nama Lengkap" required class="w-full px-4 py-2 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-yellow-400 outline-none">
                <input type="email" id="reg_email" placeholder="Email Aktif" required class="w-full px-4 py-2 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-yellow-400 outline-none">
                <input type="password" id="reg_password" placeholder="Buat Password" required class="w-full px-4 py-2 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-yellow-400 outline-none">

                <button type="submit" id="btn-register" class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-2.5 rounded-lg transition mt-2 flex justify-center items-center gap-2">
                  Daftar & Lanjut Belanja
                </button>
              </form>

              <div id="pesan-register" class="mt-4 text-sm font-semibold hidden"></div>

              <div class="mt-4 text-center text-sm text-gray-300">
                Sudah punya akun? <a href="auth/" class="text-yellow-400 font-semibold hover:underline">Login di sini</a>
              </div>
            </div>
          </div>

        </div>

      </div>
    <?php } ?>

  </div>

</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
  $(document).ready(function() {
    $('#form-register-cepat').on('submit', function(e) {
      e.preventDefault(); // Menghentikan aksi default (reload halaman)

      let btn = $('#btn-register');
      let originalText = btn.html();
      let msgBox = $('#pesan-register');

      // 1. Ubah state tombol menjadi loading
      btn.html('<i class="bi bi-arrow-repeat animate-spin text-lg"></i> Memproses...').prop('disabled', true);
      msgBox.hide().removeClass('text-green-400 text-red-400');

      // 2. Kirim data ke controller/register_ajax.php
      $.ajax({
        url: 'controller/register_ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'register_cepat',
          name: $('#reg_name').val(),
          email: $('#reg_email').val(),
          password: $('#reg_password').val()
        },
        success: function(response) {
          if (response.status === 'success') {
            // Jika Sukses: Tampilkan pesan hijau
            msgBox.html('<i class="bi bi-check-circle"></i> ' + response.message).addClass('text-green-400').fadeIn();

            // SULAP UX: Hilangkan form daftar, dan munculkan tombol Checkout dengan animasi
            setTimeout(function() {
              $('#box-register').slideUp(400); // Form pendaftaran menghilang ke atas
              $('#area-peringatan').fadeOut(200, function() { // Box kuning menghilang
                $('#area-checkout').hide().removeClass('hidden').fadeIn(600); // Tombol Checkout Hijau Muncul
              });
            }, 1500); // Jeda 1.5 detik agar user sempat membaca tulisan berhasil

          } else {
            // Jika Gagal (misal email sudah ada): Tampilkan peringatan merah
            msgBox.html('<i class="bi bi-x-circle"></i> ' + response.message).addClass('text-red-400').fadeIn();
            btn.html(originalText).prop('disabled', false); // Kembalikan tombol
          }
        },
        error: function() {
          // Jika server error (misal koneksi putus / error 500)
          msgBox.html('<i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan sistem. Coba lagi.').addClass('text-red-400').fadeIn();
          btn.html(originalText).prop('disabled', false);
        }
      });
    });
  });
</script>

<?php require_once("sections/front_footer.php"); ?>