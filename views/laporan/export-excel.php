<?php
require_once("../../controller/laporan.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Menangkap nilai filter dari URL
$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
$nama_bulan_dipilih = $nama_bulan[(int)$filter_bulan];

// Query data laporan (Sama persis dengan yang di controller laporan.php)
$query_laporan = "SELECT 
                    tabel_pesanan.id_pesanan,
                    users.name AS nama_pembeli,
                    COUNT(tabel_transaksi.id_transaksi) AS total_item,
                    SUM(tabel_transaksi.total_harga) AS grand_total,
                    MAX(tabel_transaksi.tanggal_transaksi) AS tanggal_transaksi
                  FROM tabel_pesanan
                  JOIN users ON tabel_pesanan.id_user = users.id_user
                  JOIN tabel_transaksi ON tabel_pesanan.id_pesanan = tabel_transaksi.id_pesanan
                  WHERE tabel_pesanan.status_pesanan = 'Selesai' 
                    AND MONTH(tabel_transaksi.tanggal_transaksi) = '$filter_bulan'
                    AND YEAR(tabel_transaksi.tanggal_transaksi) = '$filter_tahun'
                  GROUP BY tabel_pesanan.id_pesanan, users.name
                  ORDER BY tanggal_transaksi ASC";

$views_laporan = mysqli_query($conn, $query_laporan);

// Inisialisasi objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Judul Sheet
$sheet->setTitle('Laporan Penjualan');

// Set Header Laporan di Excel
$sheet->setCellValue('A1', 'REKAPITULASI PENJUALAN TOKO SUMBER LOGAM');
$sheet->setCellValue('A2', 'Periode: ' . $nama_bulan_dipilih . ' ' . $filter_tahun);
$sheet->mergeCells('A1:F1');
$sheet->mergeCells('A2:F2');

// Styling Header Laporan (Tengah dan Bold)
$styleJudul = [
  'font' => ['bold' => true, 'size' => 14],
  'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
];
$sheet->getStyle('A1:A2')->applyFromArray($styleJudul);

// Header Tabel
$sheet->setCellValue('A4', 'No');
$sheet->setCellValue('B4', 'Tanggal');
$sheet->setCellValue('C4', 'ID Pesanan');
$sheet->setCellValue('D4', 'Nama Pelanggan');
$sheet->setCellValue('E4', 'Total Item');
$sheet->setCellValue('F4', 'Total Harga');

// Styling Header Tabel
$styleHeaderTabel = [
  'font' => ['bold' => true],
  'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
  'borders' => [
    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
  ],
  'fill' => [
    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    'startColor' => ['rgb' => 'E2EFDA'] // Warna background hijau muda
  ]
];
$sheet->getStyle('A4:F4')->applyFromArray($styleHeaderTabel);

// Looping Data ke Excel
$row_excel = 5; // Mulai dari baris ke-5
$no = 1;
$grand_total_pendapatan = 0;

if (mysqli_num_rows($views_laporan) > 0) {
  while ($data = mysqli_fetch_assoc($views_laporan)) {
    $grand_total_pendapatan += $data['grand_total'];

    $sheet->setCellValue('A' . $row_excel, $no++);
    $sheet->setCellValue('B' . $row_excel, date('d/m/Y', strtotime($data['tanggal_transaksi'])));
    $sheet->setCellValue('C' . $row_excel, 'ORD-' . str_pad($data['id_pesanan'], 4, '0', STR_PAD_LEFT));
    $sheet->setCellValue('D' . $row_excel, $data['nama_pembeli']);
    $sheet->setCellValue('E' . $row_excel, $data['total_item'] . ' Barang');
    $sheet->setCellValue('F' . $row_excel, $data['grand_total']); // Jangan di-number_format di sini agar bisa dijumlah di Excel

    // Format angka menjadi mata uang rupiah di Excel
    $sheet->getStyle('F' . $row_excel)->getNumberFormat()->setFormatCode('"Rp "#,##0');

    $row_excel++;
  }
} else {
  $sheet->setCellValue('A5', 'Tidak ada transaksi pada periode ini.');
  $sheet->mergeCells('A5:F5');
  $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
  $row_excel++;
}

// Tambahkan Baris Grand Total di bawah
$sheet->setCellValue('A' . $row_excel, 'TOTAL PENDAPATAN');
$sheet->mergeCells('A' . $row_excel . ':E' . $row_excel);
$sheet->setCellValue('F' . $row_excel, $grand_total_pendapatan);

// Styling Baris Total
$styleTotal = [
  'font' => ['bold' => true],
  'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
  'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
];
$sheet->getStyle('A' . $row_excel . ':F' . $row_excel)->applyFromArray($styleTotal);
$sheet->getStyle('F' . $row_excel)->getNumberFormat()->setFormatCode('"Rp "#,##0');

// Styling Border untuk semua data
$styleData = [
  'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
];
$sheet->getStyle('A4:F' . ($row_excel - 1))->applyFromArray($styleData);

// Auto-size lebar kolom agar rapi
foreach (range('A', 'F') as $columnID) {
  $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Set Header HTTP agar file terdownload otomatis
$nama_file = "Laporan_Penjualan_" . $nama_bulan_dipilih . "_" . $filter_tahun . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nama_file . '"');
header('Cache-Control: max-age=0');

// Simpan via output browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
