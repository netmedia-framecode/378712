<?php
require_once("controller/visitor.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Katalog Produk";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");
?>

<main class="flex-grow bg-gray-50 pb-16">

  <div class="bg-primary text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl md:text-4xl font-extrabold mb-4 text-center">Katalog Produk</h1>
      <p class="text-blue-100 text-center mb-8 max-w-2xl mx-auto">
        Temukan material bangunan terbaik untuk proyek Anda. Gunakan kotak pencarian di bawah untuk mencari barang spesifik.
      </p>

      <form action="katalog.php" method="GET" class="max-w-3xl mx-auto relative">
        <div class="flex shadow-lg rounded-xl overflow-hidden">
          <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <i class="bi bi-search text-gray-400"></i>
            </div>
            <input type="text" name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
              class="block w-full pl-11 pr-4 py-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 border-none"
              placeholder="Cari nama barang atau kode (cth: Semen, Cat, Besi)...">
          </div>
          <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold px-8 py-4 transition duration-300">
            Cari
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-6 flex justify-between items-center">
    <div>
      <?php if (isset($_GET['q']) && $_GET['q'] != '') { ?>
        <h2 class="text-xl font-bold text-gray-800">
          Hasil pencarian untuk: <span class="text-primary">"<?= htmlspecialchars($_GET['q']) ?>"</span>
        </h2>
      <?php } else { ?>
        <h2 class="text-xl font-bold text-gray-800">Semua Produk</h2>
      <?php } ?>
      <p class="text-sm text-gray-500 mt-1">Menampilkan <?= $total_produk ?> produk tersedia.</p>
    </div>

    <?php if (isset($_GET['q']) && $_GET['q'] != '') { ?>
      <a href="katalog.php" class="text-sm font-semibold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-md transition">
        <i class="bi bi-x-circle me-1"></i> Reset Filter
      </a>
    <?php } ?>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

      <?php
      if (isset($result_katalog) && mysqli_num_rows($result_katalog) > 0) {
        while ($item = mysqli_fetch_assoc($result_katalog)) {
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
                    <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php
        }
      } else {
        ?>
        <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-12 text-center">
          <i class="bi bi-box-seam text-6xl text-gray-300 mb-4 block"></i>
          <h3 class="text-xl font-bold text-gray-800 mb-2">Barang Tidak Ditemukan</h3>
          <p class="text-gray-500">Maaf, barang yang Anda cari tidak tersedia atau stok sedang kosong.</p>
          <a href="katalog.php" class="mt-6 inline-block bg-primary text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">
            Lihat Semua Barang
          </a>
        </div>
      <?php } ?>

    </div>
  </div>

</main>

<?php require_once("sections/front_footer.php"); ?>