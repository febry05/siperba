<?php
// require 'vendor/autoload.php'; // Sesuaikan jika tanpa Composer

require_once __DIR__ . './vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Konfigurasi Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Data contoh
$data = [
    [
        'tanggal' => '2 Juni 2025',
        'nomor_surat' => '001',
        'nama_barang' => 'Pulpen',
        'jenis' => 'Atk',
        'jumlah' => 2,
        'satuan' => 'pcs',
        'status' => 'Disetujui',
        'nama' => 'Budi Santoso',
        'divisi' => 'Umum',
        'status_pegawai' => 'Aktif'
    ]
];

// HTML laporan
$html = '
<style>
    body { font-family: sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 10px; }
    .header img { float: right; width: 80px; height: auto; }
    .title { text-align: center; font-weight: bold; font-size: 16px; margin-top: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    table, th, td { border: 1px solid black; }
    th, td { padding: 5px; text-align: center; }
    .signature { margin-top: 50px; text-align: right; }
</style>

<div class="header">
    <div>
        Dinas Provinsi Kalimantan Selatan<br>
        Jln Jend A. Yani Km 7,5 hanyar,<br>
        Kabupaten Banjar Kode Pos 70654<br>
        Telp (0511) 6795599<br>
        Email : disparprovkalsel
    </div>
    <img src="logo.png" alt="Logo">
</div>

<div class="title">Laporan Permintaan Barang</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nomor Surat</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Status Permintaan</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($data as $row) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . $row['tanggal'] . '</td>
        <td>' . $row['nomor_surat'] . '</td>
        <td>' . $row['nama_barang'] . '</td>
        <td>' . $row['jenis'] . '</td>
        <td>' . $row['jumlah'] . '</td>
        <td>' . $row['satuan'] . '</td>
        <td>' . $row['status'] . '</td>
        <td>' . $row['nama'] . '</td>
        <td>' . $row['divisi'] . '</td>
        <td>' . $row['status_pegawai'] . '</td>
    </tr>';
}

$html .= '</tbody>
</table>

<div class="signature">
    Tertanda
</div>
';

// Render PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_permintaan_barang.pdf", ["Attachment" => false]);
exit;