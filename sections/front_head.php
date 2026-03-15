<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $data_utilities['name_web'] . " - Toko Bahan Bangunan" ?></title>
  <meta name="keywords" content="<?= $data_utilities['keyword'] ?>">
  <meta name="description" content="<?= $data_utilities['description'] ?>">
  <meta name="author" content="<?= $data_utilities['author'] ?>">
  <link rel="icon" href="<?= $baseURL ?>assets/img/<?= $data_utilities['logo'] ?>" type="image/png">

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3454d1', // Warna biru seragam dengan dashboard
            secondary: '#f8f9fa',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">
  <?php if (isset($_GET['order']) && $_GET['order'] == 'success' && isset($_GET['id'])) { ?>
    <div id="modal-success" class="fixed inset-0 z-[100] flex items-center justify-center px-4 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity">
      <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10 max-w-md w-full text-center transform transition-all">
        <div class="w-24 h-24 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
          <i class="bi bi-check-circle-fill text-6xl text-green-500"></i>
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Pesanan Berhasil!</h2>
        <p class="text-gray-600 mb-6 leading-relaxed">
          Terima kasih telah mempercayakan kebutuhan bangunan Anda pada kami. Pesanan Anda akan segera diproses oleh Admin.
        </p>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8">
          <p class="text-sm text-gray-500 mb-1">ID Pesanan Anda:</p>
          <p class="text-2xl font-bold text-primary tracking-widest">
            ORD-<?= str_pad(htmlspecialchars($_GET['id']), 4, '0', STR_PAD_LEFT) ?>
          </p>
        </div>

        <button onclick="document.getElementById('modal-success').style.display='none'" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-md transition duration-300">
          Tutup & Kembali ke Beranda
        </button>
      </div>
    </div>
  <?php } ?>