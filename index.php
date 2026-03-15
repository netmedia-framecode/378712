<?php
require_once("controller/visitor.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Beranda";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");
?>

<main class="flex-grow bg-gray-50">

  <section class="relative bg-gradient-to-br from-primary to-blue-800 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
      <svg class="absolute right-0 top-0 h-full w-1/2 transform translate-x-1/3" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
        <polygon points="50,0 100,0 50,100 0,100" />
      </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="pt-20 pb-24 md:pt-28 md:pb-32 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
          <span class="inline-block py-1 px-3 rounded-full bg-blue-700 bg-opacity-50 border border-blue-400 text-sm font-semibold tracking-wider mb-6">
            Pusat Material Terlengkap
          </span>
          <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-6">
            Bangun Impian Anda Bersama <span class="text-yellow-400">Sumber Logam</span>
          </h1>
          <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-lg leading-relaxed">
            Mulai dari pondasi hingga atap, kami menyediakan material bangunan berkualitas tinggi dengan harga terbaik. Pesan online, kami antar sampai depan proyek Anda!
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="katalog" class="bg-yellow-400 text-gray-900 hover:bg-yellow-300 font-bold px-8 py-3.5 rounded-lg shadow-lg transform transition hover:-translate-y-1 text-center">
              <i class="bi bi-cart2 me-2"></i> Belanja Sekarang
            </a>
            <a href="#cara-belanja" class="bg-blue-700 bg-opacity-40 hover:bg-opacity-60 text-white font-semibold px-8 py-3.5 rounded-lg border border-blue-500 transition text-center">
              Cara Pemesanan
            </a>
          </div>
        </div>
        <div class="hidden md:block relative">
          <div class="absolute inset-0 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
          <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Material Bangunan" class="rounded-2xl shadow-2xl border-4 border-white/10 relative z-10 object-cover h-[400px] w-full">
        </div>
      </div>
    </div>
  </section>

  <section id="cara-belanja" class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-900">Belanja Makin Praktis</h2>
        <p class="mt-4 text-gray-500">Ikuti 4 langkah mudah ini untuk memenuhi kebutuhan bangunan Anda.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-blue-50 transition duration-300 border border-transparent hover:border-blue-100 group">
          <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm text-primary mb-4 group-hover:scale-110 transition">
            <i class="bi bi-search text-2xl"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">1. Pilih Barang</h3>
          <p class="text-gray-500 text-sm">Eksplorasi katalog kami dan pilih material yang Anda butuhkan.</p>
        </div>
        <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-blue-50 transition duration-300 border border-transparent hover:border-blue-100 group">
          <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm text-primary mb-4 group-hover:scale-110 transition">
            <i class="bi bi-cart-plus text-2xl"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">2. Masukkan Keranjang</h3>
          <p class="text-gray-500 text-sm">Kumpulkan barang di keranjang belanja Anda sebelum checkout.</p>
        </div>
        <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-blue-50 transition duration-300 border border-transparent hover:border-blue-100 group">
          <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm text-primary mb-4 group-hover:scale-110 transition">
            <i class="bi bi-person-check text-2xl"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">3. Login & Checkout</h3>
          <p class="text-gray-500 text-sm">Masuk ke akun Anda, isi alamat pengiriman, dan buat pesanan.</p>
        </div>
        <div class="text-center p-6 rounded-2xl bg-gray-50 hover:bg-blue-50 transition duration-300 border border-transparent hover:border-blue-100 group">
          <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm text-primary mb-4 group-hover:scale-110 transition">
            <i class="bi bi-truck text-2xl"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">4. Barang Diantar</h3>
          <p class="text-gray-500 text-sm">Admin kami akan memproses, dan barang siap dikirim ke lokasi!</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-10">
      <div>
        <h2 class="text-3xl font-extrabold text-gray-900">Rekomendasi Produk</h2>
        <p class="mt-2 text-gray-500">Material unggulan siap dikirim hari ini.</p>
      </div>
      <a href="katalog" class="hidden md:inline-flex items-center text-primary font-semibold hover:text-blue-800 transition">
        Lihat Semua Katalog <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
      <?php
      if (isset($result_produk) && mysqli_num_rows($result_produk) > 0) {
        while ($item = mysqli_fetch_assoc($result_produk)) {
      ?>
          <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col">
            <div class="h-48 bg-gray-100 relative overflow-hidden flex items-center justify-center text-gray-400">
              <i class="bi bi-image text-5xl group-hover:scale-110 transition duration-500"></i>
              <div class="absolute top-3 left-3 bg-white px-2 py-1 rounded text-xs font-bold text-gray-700 shadow-sm">
                Stok: <?= $item['stok_tersedia'] ?>
              </div>
            </div>
            <div class="p-5 flex-grow flex flex-col justify-between">
              <div>
                <p class="text-xs text-gray-400 mb-1 uppercase tracking-wider"><?= $item['kode_katalog'] ?></p>
                <h3 class="font-bold text-gray-900 text-lg leading-tight mb-2 line-clamp-2">
                  <?= htmlspecialchars($item['nama_barang']) ?>
                </h3>
              </div>
              <div class="mt-4">
                <p class="text-xl font-extrabold text-primary mb-4">
                  Rp <?= number_format((float)$item['harga_barang'], 0, ',', '.') ?> <span class="text-sm font-normal text-gray-500">/ <?= $item['satuan'] ?></span>
                </p>
                <form action="" method="POST">
                  <input type="hidden" name="kode_katalog" value="<?= $item['kode_katalog'] ?>">
                  <button type="submit" name="add_to_cart" class="block w-full text-center bg-gray-50 hover:bg-primary hover:text-white text-gray-800 border border-gray-200 hover:border-transparent font-semibold py-2.5 rounded-lg transition duration-300">
                    <i class="bi bi-cart-plus me-1"></i> Tambah
                  </button>
                </form>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p class='col-span-full text-center text-gray-500 py-10'>Belum ada produk yang tersedia saat ini.</p>";
      }
      ?>
    </div>

    <div class="mt-8 text-center md:hidden">
      <a href="katalog" class="inline-flex items-center text-primary font-semibold hover:text-blue-800 transition">
        Lihat Semua Katalog <i class="bi bi-arrow-right ms-2"></i>
      </a>
    </div>
  </section>

  <section class="bg-white py-16 border-t border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-gradient-to-r from-blue-900 to-primary rounded-3xl p-8 md:p-12 text-center text-white shadow-2xl relative overflow-hidden">
        <i class="bi bi-buildings absolute -right-10 -bottom-10 text-9xl text-white opacity-10"></i>
        <div class="relative z-10">
          <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Mulai Proyek Anda Sekarang!</h2>
          <p class="text-blue-100 mb-8 max-w-2xl mx-auto text-lg">
            Daftarkan akun Anda hari ini untuk mempermudah proses pemesanan, melacak status pengiriman, dan melihat riwayat belanja Anda.
          </p>
          <a href="auth/register" class="inline-block bg-yellow-400 text-gray-900 hover:bg-yellow-300 font-bold px-8 py-4 rounded-xl shadow-lg transform transition hover:-translate-y-1">
            Daftar Akun Gratis <i class="bi bi-person-plus ms-2"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php require_once("sections/front_footer.php"); ?>