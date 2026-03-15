<?php
require_once("controller/visitor.php");
$_SESSION["project_si_penjualan_bahan_bangunan"]["name_page"] = "Kontak Kami";
require_once("sections/front_head.php");
require_once("sections/front_navbar.php");
?>

<main class="flex-grow bg-gray-50 pb-16">

  <div class="bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Hubungi Kami</h1>
      <p class="text-blue-100 text-lg max-w-2xl mx-auto">Informasi kontak dan lokasi Toko Sumber Logam. Kami siap melayani kebutuhan material bangunan Anda.</p>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

      <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center flex flex-col items-center hover:-translate-y-2 transition duration-300">
        <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mb-6">
          <i class="bi bi-geo-alt text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Alamat Toko</h3>
        <p class="text-gray-500 text-sm">Jl. Contoh Alamat No. 123<br>Kecamatan, Kota, Provinsi 12345</p>
      </div>

      <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center flex flex-col items-center hover:-translate-y-2 transition duration-300">
        <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mb-6">
          <i class="bi bi-telephone text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Telepon / WhatsApp</h3>
        <p class="text-gray-500 text-sm mt-1">0878-7346-3780</p>
        <a href="https://wa.me/6287873463780" target="_blank" class="mt-4 text-primary font-semibold hover:text-blue-800 text-sm transition">
          Chat via WhatsApp <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>

      <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center flex flex-col items-center hover:-translate-y-2 transition duration-300">
        <div class="w-16 h-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mb-6">
          <i class="bi bi-clock text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Jam Operasional</h3>
        <p class="text-gray-500 text-sm">Senin - Sabtu: 08.00 - 17.00 WITA<br>Minggu: Libur / Tutup</p>
      </div>

    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-extrabold text-gray-900">Lokasi Kami</h2>
      <p class="mt-2 text-gray-500">Kunjungi toko fisik kami untuk melihat langsung kualitas material yang kami sediakan.</p>
    </div>
    <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 h-[500px] overflow-hidden">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126214.40794593922!2d123.5132890600005!3d-10.158563337920409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569c73e0a13c33%3A0xcda8d0d4ba17e80!2sKupang%2C%20Kota%20Kupang%2C%20Nusa%20Tenggara%20Tim.!5e0!3m2!1sid!2sid!4v1710466453666!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-xl"></iframe>
    </div>
  </div>

</main>

<?php require_once("sections/front_footer.php"); ?>