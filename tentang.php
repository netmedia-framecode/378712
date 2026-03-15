<?php
require_once("controller/visitor.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Tentang Kami";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");
?>

<main class="flex-grow bg-gray-50 pb-16">

  <div class="bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Tentang Kami</h1>
      <p class="text-blue-100 text-lg max-w-2xl mx-auto">Mengenal lebih dekat Toko Sumber Logam, mitra terpercaya untuk segala kebutuhan konstruksi Anda.</p>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-8 md:p-12 flex flex-col justify-center">
          <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2">Sejarah Kami</span>
          <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Membangun Kepercayaan Sejak 2010</h2>
          <div class="text-gray-600 space-y-4 leading-relaxed">
            <p>
              Berawal dari sebuah toko kecil yang menyediakan alat pertukangan dasar, <strong>Sumber Logam</strong> kini telah berkembang menjadi salah satu pusat penyedia material bangunan terlengkap di kota ini.
            </p>
            <p>
              Kami menyadari bahwa setiap bangunan yang kokoh berawal dari material yang berkualitas. Oleh karena itu, kami selalu berkomitmen untuk hanya menyediakan produk-produk standar SNI dengan harga yang jujur dan bersaing.
            </p>
          </div>
        </div>
        <div class="h-64 md:h-auto bg-gray-200 relative">
          <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Gudang Material" class="absolute inset-0 w-full h-full object-cover">
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-extrabold text-gray-900">Mengapa Memilih Kami?</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:-translate-y-2 transition duration-300">
        <div class="w-16 h-16 mx-auto bg-blue-50 text-primary rounded-full flex items-center justify-center mb-6">
          <i class="bi bi-tags text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Kompetitif</h3>
        <p class="text-gray-500 text-sm">Kami menawarkan harga tangan pertama yang ramah di kantong untuk pembelian eceran maupun partai besar (grosir).</p>
      </div>
      <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:-translate-y-2 transition duration-300">
        <div class="w-16 h-16 mx-auto bg-blue-50 text-primary rounded-full flex items-center justify-center mb-6">
          <i class="bi bi-shield-check text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas Terjamin</h3>
        <p class="text-gray-500 text-sm">Semua material yang kami jual telah melewati proses seleksi kualitas yang ketat untuk memastikan bangunan Anda kokoh.</p>
      </div>
      <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:-translate-y-2 transition duration-300">
        <div class="w-16 h-16 mx-auto bg-blue-50 text-primary rounded-full flex items-center justify-center mb-6">
          <i class="bi bi-truck text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Pengiriman Cepat</h3>
        <p class="text-gray-500 text-sm">Armada pengiriman kami selalu siap mengantarkan pesanan Anda langsung ke lokasi proyek dengan aman dan tepat waktu.</p>
      </div>
    </div>
  </div>

</main>

<?php require_once("sections/front_footer.php"); ?>