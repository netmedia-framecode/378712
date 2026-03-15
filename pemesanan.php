<?php
require_once("controller/visitor.php");

// Proteksi Halaman
if (!isset($_SESSION['project_si_penjualan_bahan_bangunan']['users']['id'])) {
  header("Location: auth/");
  exit();
}

$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Pemesanan Saya";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");

$id_user = $_SESSION['project_si_penjualan_bahan_bangunan']['users']['id'];

// Ambil data pesanan
$query_pesanan = mysqli_query($conn, "SELECT * FROM tabel_pesanan WHERE id_user = '$id_user' ORDER BY id_pesanan DESC");
$ada_pesanan = mysqli_num_rows($query_pesanan) > 0;
?>

<main class="flex-grow bg-gray-50 pb-16">

  <div class="bg-primary text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold">Riwayat Pesanan</h1>
      <p class="text-blue-100 mt-2">Pantau status pengiriman dan riwayat belanja Anda di sini.</p>
    </div>
  </div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

    <?php if (!$ada_pesanan) { ?>
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center mt-10">
        <i class="bi bi-receipt text-6xl text-gray-300 mb-4 block"></i>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Transaksi</h3>
        <p class="text-gray-500 mb-6">Anda belum pernah melakukan pemesanan. Yuk, mulai bangun proyek impian Anda!</p>
        <a href="katalog.php" class="inline-block bg-primary text-white font-semibold px-8 py-3 rounded-xl hover:bg-blue-700 transition">
          Mulai Belanja
        </a>
      </div>
    <?php } else { ?>
      <div class="space-y-5">

        <?php
        while ($pesanan = mysqli_fetch_assoc($query_pesanan)) {
          $id_pesanan = $pesanan['id_pesanan'];
          $kode_order = "ORD-" . str_pad($id_pesanan, 4, '0', STR_PAD_LEFT);
          $tanggal = date('d M Y, H:i', strtotime($pesanan['tanggal_pesan']));
          $status = $pesanan['status_pesanan'];

          // Menentukan Warna Badge Status
          $badge_class = "bg-gray-100 text-gray-800";
          if ($status == 'Menunggu Konfirmasi') $badge_class = "bg-yellow-100 text-yellow-800";
          if ($status == 'Diproses') $badge_class = "bg-blue-100 text-blue-800";
          if ($status == 'Selesai') $badge_class = "bg-green-100 text-green-800";
          if ($status == 'Batal') $badge_class = "bg-red-100 text-red-800";

          // Hitung total harga dan jumlah item untuk ringkasan (tanpa perlu loop semua barang dulu)
          $query_summary = mysqli_query($conn, "SELECT SUM(total_harga) as grand_total, COUNT(id_transaksi) as total_item FROM tabel_transaksi WHERE id_pesanan = '$id_pesanan'");
          $summary = mysqli_fetch_assoc($query_summary);
          $grand_total = $summary['grand_total'] ?? 0;
          $total_item = $summary['total_item'] ?? 0;
        ?>

          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-300">

            <div class="p-6">
              <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">

                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-primary flex-shrink-0 mt-1">
                    <i class="bi bi-box-seam text-2xl"></i>
                  </div>
                  <div>
                    <div class="flex items-center gap-3 mb-1">
                      <h3 class="text-lg font-extrabold text-gray-900"><?= $kode_order ?></h3>
                      <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider <?= $badge_class ?>">
                        <?= $status ?>
                      </span>
                    </div>
                    <p class="text-sm text-gray-500"><i class="bi bi-calendar3 me-1"></i> <?= $tanggal ?> WITA &nbsp;&bull;&nbsp; <?= $total_item ?> Jenis Barang</p>
                  </div>
                </div>

                <div class="flex flex-row md:flex-col justify-between items-center md:items-end w-full md:w-auto mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                  <div class="text-left md:text-right mb-0 md:mb-2">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Total Belanja</p>
                    <p class="text-lg font-bold text-primary">Rp <?= number_format($grand_total, 0, ',', '.') ?></p>
                  </div>
                  <button onclick="toggleDetail('<?= $id_pesanan ?>')" class="text-sm font-semibold text-gray-600 hover:text-primary transition flex items-center gap-1 bg-gray-50 hover:bg-blue-50 px-3 py-1.5 rounded-lg border border-gray-200">
                    Detail Pesanan <i id="icon-<?= $id_pesanan ?>" class="bi bi-chevron-down transition-transform duration-300"></i>
                  </button>
                </div>

              </div>
            </div>

            <div id="detail-<?= $id_pesanan ?>" class="hidden bg-gray-50 border-t border-gray-100 p-6">
              <h4 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Rincian Barang</h4>
              <div class="space-y-3">
                <?php
                $query_detail = mysqli_query($conn, "
                                SELECT t.jumlah_barang, t.total_harga, k.nama_barang, k.satuan 
                                FROM tabel_transaksi t 
                                JOIN tabel_katalog k ON t.kode_katalog = k.kode_katalog 
                                WHERE t.id_pesanan = '$id_pesanan'
                            ");

                while ($detail = mysqli_fetch_assoc($query_detail)) {
                ?>
                  <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <div>
                      <p class="font-bold text-gray-800 line-clamp-1"><?= htmlspecialchars($detail['nama_barang']) ?></p>
                      <p class="text-sm text-gray-500 mt-0.5"><?= $detail['jumlah_barang'] ?> <?= $detail['satuan'] ?></p>
                    </div>
                    <span class="font-bold text-gray-900">Rp <?= number_format($detail['total_harga'], 0, ',', '.') ?></span>
                  </div>
                <?php } ?>
              </div>
            </div>

          </div>
        <?php } ?>

      </div>
    <?php } ?>

  </div>

</main>

<script>
  function toggleDetail(id) {
    const detailBox = document.getElementById('detail-' + id);
    const icon = document.getElementById('icon-' + id);

    // Toggle class hidden bawaan Tailwind
    if (detailBox.classList.contains('hidden')) {
      detailBox.classList.remove('hidden');
      // Putar ikon panah ke atas
      icon.classList.remove('bi-chevron-down');
      icon.classList.add('bi-chevron-up');
    } else {
      detailBox.classList.add('hidden');
      // Putar ikon panah ke bawah
      icon.classList.remove('bi-chevron-up');
      icon.classList.add('bi-chevron-down');
    }
  }
</script>

<?php require_once("sections/front_footer.php"); ?>