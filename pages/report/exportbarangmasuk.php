<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;

$logoPath = __DIR__ . '/../../assets/images/wonderfull.jpg';
if (file_exists($logoPath)) {
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logo = 'data:image/png;base64,' . $logoBase64;
} else {
    $logo = ''; // atau logo default
}


// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "siperba"; // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil filter dari for
$tanggal = $_GET['tanggal'] ?? '';
$tgl = date('Y-m', strtotime($tanggal));
$supplier  = $_GET['supplier'] ?? '';



$sql = "SELECT barang_masuk.*, supplier.nama_supplier, pegawai.nama_pegawai, barang.nama_barang, barang.kode_barang,jenis.jenis_barang,barang.satuan
    FROM barang_masuk
    LEFT JOIN supplier ON barang_masuk.id_supplier = supplier.id_supplier
    LEFT JOIN pegawai ON barang_masuk.id_pegawai = pegawai.id_pegawai
    LEFT JOIN barang ON barang_masuk.id_barang = barang.id_barang
    LEFT JOIN jenis ON jenis.id_jenis = barang.id_jenis
    WHERE 1=1";

// Tambahkan filter
if (!empty($tanggal)) {
    // Pastikan format aman (YYYY-MM)
    if (preg_match('/^\d{4}-\d{2}$/', $tgl)) {
        $sql .= " AND DATE_FORMAT(barang_masuk.tanggal_masuk, '%Y-%m') = '$tgl'";
    }
}

if (!empty($supplier)) {
    $sql .= " AND  barang_masuk.id_supplier = '$supplier'";
}

$sql .= " ORDER BY barang_masuk.id_barang_masuk ASC";

$result = $conn->query($sql);



// Siapkan HTML untuk PDF
$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .header { text-align: center; }
    .logo { float: right; width: 70px; height: 70px; border: 1px solid #000; text-align: center; }
    .title { font-size: 16px; font-weight: bold; margin-top: 10px; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid black; padding: 4px; text-align: center; }
    .footer { margin-top: 40px; text-align: right; }
</style>

<div class="header">
    <div style="position: absolute; top: 20px; right: 40px;" class="logo"> <img src="' . $logo . '" class="logo" /></div>
    <div>Dinas Provinsi Kalimantan Selatan<br>
    Jln Jend A. Yani Km 7,5 hanyar, Kabupaten Banjar Kode Pos 70654<br>
    Telp (0511) 6795594<br>
    Email : disparprovkalsel</div>
</div>

<div class="title">Laporan Barang Masuk</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     
        $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . $row['tanggal_masuk'] . '</td>
            <td>' . $row['nama_barang'] . '</td>
            <td>' . $row['jenis_barang'] . '</td>
            <td>' . $row['jumlah'] . '</td>
            <td>' . $row['satuan'] . '</td>
            <td>' . $row['harga_satuan'] . '</td>
            <td>' . $row['total'] . '</td>
            <td>' . $row['nama_supplier'] . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="11">Data tidak ditemukan</td></tr>';
}

$html .= '
<style>
.footer {
    margin-top: 50px;
    text-align: right;
    padding-right: 100px; /* geser ke kiri */
}
</style>

    </tbody>
</table>

<div class="footer">Tertanda</div>
';

$conn->close();

// Export ke PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_pegawai.pdf', ['Attachment' => false]);