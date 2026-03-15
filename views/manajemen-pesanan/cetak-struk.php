<?php
require_once("../../controller/manajemen-pesanan.php");

if (!isset($_GET["p"])) {
  die("ID Pesanan tidak valid.");
}

$id = valid($conn, $_GET["p"]);

// 1. Mengambil data pesanan dan pelanggan
$pull_pesanan = "SELECT 
                  tabel_pesanan.id_pesanan, 
                  tabel_pesanan.tanggal_pesan,
                  users.name,
                  tabel_pelanggan.nomor_telepon,
                  tabel_pelanggan.alamat
                 FROM tabel_pesanan 
                 JOIN users ON tabel_pesanan.id_user = users.id_user 
                 LEFT JOIN tabel_pelanggan ON users.id_user = tabel_pelanggan.id_user
                 WHERE tabel_pesanan.id_pesanan = '$id' AND tabel_pesanan.status_pesanan = 'Selesai'";
$store_pesanan = mysqli_query($conn, $pull_pesanan);
$view_pesanan = mysqli_fetch_assoc($store_pesanan);

if (!$view_pesanan) {
  die("Data transaksi tidak ditemukan atau belum selesai.");
}

// 2. Mengambil detail transaksi barang
$pull_transaksi = "SELECT 
                    tabel_transaksi.jumlah_barang,
                    tabel_transaksi.total_harga,
                    tabel_katalog.nama_barang,
                    tabel_katalog.harga_barang,
                    tabel_katalog.satuan
                   FROM tabel_transaksi 
                   JOIN tabel_katalog ON tabel_transaksi.kode_katalog = tabel_katalog.kode_katalog 
                   WHERE tabel_transaksi.id_pesanan = '$id'";
$view_transaksi = mysqli_query($conn, $pull_transaksi);

$grand_total = 0;

// ==========================================
// 3. MULAI BUFFERING HTML UNTUK PDF
// ==========================================
ob_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Invoice ORD-<?= str_pad($view_pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT) ?></title>
  <style>
    /* CSS Khusus untuk mPDF agar rapi */
    body {
      font-family: Arial, sans-serif;
      font-size: 10pt;
      color: #333;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .header h2 {
      margin: 0;
      padding: 0;
      color: #0056b3;
    }

    .header p {
      margin: 5px 0 0 0;
      font-size: 9pt;
      color: #666;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    th {
      background-color: #f4f4f4;
      text-align: center;
      font-weight: bold;
    }

    .text-center {
      text-align: center;
    }

    .text-end {
      text-align: right;
    }

    .fw-bold {
      font-weight: bold;
    }

    .info-toko,
    .info-pelanggan {
      width: 50%;
      float: left;
      margin-bottom: 20px;
    }

    .clear {
      clear: both;
    }
  </style>
</head>

<body>

  <div class="header">
    <h2>TOKO SUMBER LOGAM</h2>
    <p>Jl. Contoh Alamat Toko No. 123, Kota Anda | Telp: 0812-3456-7890</p>
  </div>

  <div>
    <div class="info-toko">
      <strong>INVOICE TRANSAKSI</strong><br>
      ID Pesanan : ORD-<?= str_pad($view_pesanan['id_pesanan'], 4, '0', STR_PAD_LEFT) ?><br>
      Tanggal : <?= date('d M Y, H:i', strtotime($view_pesanan['tanggal_pesan'])) ?>
    </div>

    <div class="info-pelanggan text-end">
      <strong>Informasi Pelanggan:</strong><br>
      <?= htmlspecialchars($view_pesanan['name']) ?><br>
      <?= htmlspecialchars($view_pesanan['nomor_telepon'] ?? '-') ?><br>
      <?= htmlspecialchars($view_pesanan['alamat'] ?? '-') ?>
    </div>
    <div class="clear"></div>
  </div>

  <table>
    <thead>
      <tr>
        <th width="5%">No</th>
        <th width="45%">Nama Barang</th>
        <th width="15%">Harga Satuan</th>
        <th width="15%">Qty</th>
        <th width="20%">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while ($item = mysqli_fetch_assoc($view_transaksi)) {
        $grand_total += $item['total_harga'];
      ?>
        <tr>
          <td class="text-center"><?= $no++ ?></td>
          <td><?= $item['nama_barang'] ?></td>
          <td class="text-end">Rp <?= number_format($item['harga_barang'], 0, ',', '.') ?></td>
          <td class="text-center"><?= $item['jumlah_barang'] ?> <?= $item['satuan'] ?></td>
          <td class="text-end fw-bold">Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" class="text-end fw-bold">TOTAL PEMBAYARAN</td>
        <td class="text-end fw-bold" style="background-color: #f4f4f4;">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
      </tr>
    </tfoot>
  </table>

  <div style="margin-top: 40px; text-align: center; font-size: 9pt; color: #777;">
    <p>Terima kasih telah berbelanja di Toko Sumber Logam.</p>
    <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
  </div>

</body>

</html>
<?php
// Simpan semua output HTML di atas ke dalam variabel $html
$html = ob_get_clean();

// ==========================================
// 4. PROSES HTML KE PDF MENGGUNAKAN MPDF
// ==========================================
try {
  // Inisialisasi mPDF dengan ukuran kertas A4
  $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);

  // Tulis HTML ke PDF
  $mpdf->WriteHTML($html);

  // Output PDF
  // 'I' = Inline (Tampil di browser)
  // 'D' = Download langsung
  $nama_file = "Invoice_ORD-" . str_pad($id, 4, '0', STR_PAD_LEFT) . ".pdf";
  $mpdf->Output($nama_file, \Mpdf\Output\Destination::INLINE);
} catch (\Mpdf\MpdfException $e) {
  echo "Terjadi kesalahan saat membuat PDF: " . $e->getMessage();
}
?>