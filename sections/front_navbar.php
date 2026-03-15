<?php
// 1. Logika untuk menghitung total barang di keranjang
$total_item_keranjang = 0;
if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
  foreach ($_SESSION['keranjang'] as $qty) {
    $total_item_keranjang += $qty; // Menjumlahkan semua qty barang
  }
}
?>

<nav class="bg-white shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      <div class="flex-shrink-0 flex items-center">
        <a href="<?= $baseURL ?>" class="text-2xl font-bold text-primary flex items-center gap-2">
          <i class="bi bi-buildings"></i> <?= $data_utilities['name_web'] ?>
        </a>
      </div>

      <div class="hidden md:flex space-x-8 items-center">
        <a href="<?= $baseURL ?>" class="text-gray-900 font-medium hover:text-primary transition">Beranda</a>
        <a href="<?= $baseURL ?>katalog" class="text-gray-500 hover:text-primary transition">Katalog Barang</a>
        
        <?php if (isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id'])) { ?>
          <a href="<?= $baseURL ?>pemesanan" class="text-gray-500 hover:text-primary transition">Pemesanan Saya</a>
        <?php } else { ?>
          <a href="<?= $baseURL ?>tentang" class="text-gray-500 hover:text-primary transition">Tentang Kami</a>
          <a href="<?= $baseURL ?>kontak" class="text-gray-500 hover:text-primary transition">Kontak</a>
        <?php } ?>
      </div>

      <div class="flex items-center space-x-4">

        <a href="<?= $baseURL ?>keranjang" class="text-gray-500 hover:text-primary relative p-2">
          <i class="bi bi-cart3 text-xl"></i>
          <?php if ($total_item_keranjang > 0) { ?>
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
              <?= $total_item_keranjang ?>
            </span>
          <?php } ?>
        </a>

        <?php if (isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id'])) { ?>
          <div class="hidden md:flex items-center gap-4 border-l pl-4 ml-2">
            <div class="flex flex-col text-right">
              <span class="text-xs text-gray-400">Halo,</span>
              <span class="text-sm font-bold text-gray-800 line-clamp-1 max-w-[120px]">
                <?= htmlspecialchars($_SESSION['project_si_penjualan_bahan_bangunan']['users']['name'] ?? 'Pelanggan') ?>
              </span>
            </div>
            <a href="<?= $baseURL ?>auth/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')" class="text-red-500 hover:text-white border border-red-500 hover:bg-red-500 transition px-3 py-1.5 rounded-md text-sm font-medium flex items-center gap-1">
              <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
          </div>
        <?php } else { ?>
          <a href="<?= $baseURL ?>auth/" class="hidden md:inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 transition">
            Login / Daftar
          </a>
        <?php } ?>

        <button class="md:hidden text-gray-500 hover:text-primary focus:outline-none">
          <i class="bi bi-list text-3xl"></i>
        </button>

      </div>
    </div>
  </div>
</nav>