<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Dompdf\Dompdf;
session_start(); 

// === Konversi logo ke base64 ===
$logoPath = __DIR__ . '/../../assets/images/wonderfull.jpg';
$logo = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';

// === Koneksi database ===
$conn = new mysqli("localhost", "root", "", "siperba");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Ambil filter dari form
$startdate = $_GET['startdate'] ?? '';
$enddate = $_GET['enddate'] ?? '';
// $tgl = date('Y-m', strtotime($tanggal));
$divisi  = $_GET['divisi'] ?? '';
$usercetak = $_SESSION["nama_pegawai"];

// === Ambil nama divisi ===
$divisiText = 'Semua';
if (!empty($divisi)) {
    $stmtDivisi = $conn->prepare("SELECT nama_divisi FROM divisi WHERE id_divisi = ?");
    $stmtDivisi->bind_param("s", $divisi);
    $stmtDivisi->execute();
    $resDivisi = $stmtDivisi->get_result();
    if ($resDivisi->num_rows > 0) {
        $divisiText = $resDivisi->fetch_assoc()['nama_divisi'];
    } else {
        $divisiText = 'Tidak Diketahui';
    }
    $stmtDivisi->close();
}

// === Query data utama ===
$sql = "SELECT barang_keluar.tanggal_keluar, barang_keluar.nomor_keluar, barang.nama_barang, jenis.jenis_barang, permintaan_detail.jumlah, barang.satuan, pegawai.nama_pegawai, divisi.nama_divisi
    FROM barang_keluar
    LEFT JOIN permintaan_detail ON permintaan_detail.id_permintaan_detail = barang_keluar.id_permintaan_detail
    LEFT JOIN permintaan ON permintaan.id_permintaan = permintaan_detail.id_permintaan_detail
    LEFT JOIN pegawai ON pegawai.id_pegawai = permintaan.id_pegawai
    LEFT JOIN divisi ON divisi.id_divisi = pegawai.id_divisi
    LEFT JOIN barang ON barang.id_barang = permintaan_detail.id_barang
    LEFT JOIN jenis ON jenis.id_jenis = barang.id_jenis
    WHERE 1=1";

// Filter tanggal
if (!empty($startdate)) {
    $sql .= " AND barang_keluar.tanggal_keluar BETWEEN '$startdate' AND '$enddate'";
}

if (!empty($divisi)) {
    $sql .= " AND divisi.id_divisi = '$divisi'";
}

$sql .= " ORDER BY barang_keluar.id_barang_keluar ASC";
$result = $conn->query($sql);

// === Siapkan HTML untuk PDF ===
$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .header { text-align: center; }
    .logo { float: right; width: 70px; height: 70px; }
    .title { font-size: 16px; font-weight: bold; margin-top: 10px; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid black; padding: 4px; text-align: center; }
    .footer { margin-top: 40px; text-align: right; }
</style>

<div class="header">
    <div style="position: absolute; top: 20px; right: 40px;">
        <img src="' . $logo . '" class="logo" />
    </div>
    <div>
        Dinas Provinsi Kalimantan Selatan<br>
        Jln Jend A. Yani Km 7,5 Hanyar, Kabupaten Banjar Kode Pos 70654<br>
        Telp (0511) 6795594<br>
        Email : disparprovkalsel
    </div>
</div>

<div class="title">Laporan Barang Keluar</div>
    <div class="row">
        <div class="col-md-6">
            <div style=" margin-top: 10px;">
            <strong>Periode:</strong> ' .  date('d F Y', strtotime($startdate)).' - '. date('d F Y', strtotime($enddate)).' <br>
            <strong>Divisi:</strong> ' . $divisiText . '<br>
        </div>
         <div class="col-md-6" style="position: absolute; top: 100px; right: 40px;" >
            <div style=" margin-top: 5px;">
            <strong>Tanggal Cetak:</strong> ' . DATE('d F Y') . '<br>
            <strong>User Pencetak:</strong> ' . $usercetak. '<br>
        </div>
        </div>
    </div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nomor Transaksi</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Pegawai</th>
            <th>Divisi</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . $row['tanggal_keluar'] . '</td>
            <td>' . $row['nomor_keluar'] . '</td>
            <td>' . $row['nama_barang'] . '</td>
            <td>' . $row['jenis_barang'] . '</td>
            <td>' . $row['jumlah'] . '</td>
            <td>' . $row['satuan'] . '</td>
            <td>' . $row['nama_pegawai'] . '</td>
            <td>' . $row['nama_divisi'] . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="9">Data tidak ditemukan</td></tr>';
}

$html .= '</tbody>
</table>

<div class="footer">
    Dicetak pada: ' . date('d M Y') . '<br><br>
    Tertanda
</div>
';

$conn->close();

// === Generate PDF ===
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_barang_keluar.pdf', ['Attachment' => false]);
