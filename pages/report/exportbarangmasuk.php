<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;

// Gambar logo
$logoPath = __DIR__ . '/../../assets/images/wonderfull.jpg';
$logo = file_exists($logoPath)
    ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
    : '';

// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "siperba";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil filter dari URL
$tanggal = $_GET['tanggal'] ?? '';
$tgl = !empty($tanggal) ? date('Y-m', strtotime($tanggal)) : '';
$supplier = $_GET['supplier'] ?? '';

// Ambil nama supplier jika diset
$supplierText = 'Semua';
if (!empty($supplier)) {
    $stmt = $conn->prepare("SELECT nama_supplier FROM supplier WHERE id_supplier = ?");
    $stmt->bind_param("s", $supplier);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $supplierText = $row['nama_supplier'];
    } else {
        $supplierText = 'Tidak Diketahui';
    }
    $stmt->close();
}

// Query data
$sql = "SELECT barang_masuk.*, supplier.nama_supplier, pegawai.nama_pegawai, barang.nama_barang, 
            barang.kode_barang, jenis.jenis_barang, barang.satuan
        FROM barang_masuk
        LEFT JOIN supplier ON barang_masuk.id_supplier = supplier.id_supplier
        LEFT JOIN pegawai ON barang_masuk.id_pegawai = pegawai.id_pegawai
        LEFT JOIN barang ON barang_masuk.id_barang = barang.id_barang
        LEFT JOIN jenis ON jenis.id_jenis = barang.id_jenis
        WHERE 1=1";

if (!empty($tgl)) {
    $sql .= " AND DATE_FORMAT(barang_masuk.tanggal_masuk, '%Y-%m') = '$tgl'";
}

if (!empty($supplier)) {
    $sql .= " AND barang_masuk.id_supplier = '$supplier'";
}

$sql .= " ORDER BY barang_masuk.id_barang_masuk ASC";

$result = $conn->query($sql);

// Siapkan HTML
$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .header { text-align: center; }
    .logo { float: right; width: 70px; height: 70px; border: 1px solid #000; }
    .title { font-size: 16px; font-weight: bold; margin-top: 10px; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid black; padding: 4px; text-align: center; }
    .footer { margin-top: 50px; text-align: right; padding-right: 100px; }
</style>

<div class="header">
    <div style="position: absolute; top: 20px; right: 40px;" class="logo">
        <img src="' . $logo . '" class="logo" />
    </div>
    <div>
        Dinas Provinsi Kalimantan Selatan<br>
        Jln Jend A. Yani Km 7,5 Hanyar, Kabupaten Banjar Kode Pos 70654<br>
        Telp (0511) 6795594<br>
        Email : disparprovkalsel
    </div>
</div>

<div class="title">Laporan Barang Masuk</div>
<div style="margin-top: 5px;">
    <strong>Periode:</strong> ' . (!empty($tanggal) ? date('F Y', strtotime($tanggal)) : 'Semua') . '<br>
    <strong>Supplier:</strong> ' . $supplierText . '
</div>

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
            <td>' . number_format($row['harga_satuan'], 0, ',', '.') . '</td>
            <td>' . number_format($row['total'], 0, ',', '.') . '</td>
            <td>' . $row['nama_supplier'] . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="9">Data tidak ditemukan</td></tr>';
}

$html .= '
    </tbody>
</table>

<div class="footer">
    Dicetak pada: ' . date('d-m-Y') . '<br><br>
    Tertanda
</div>
';

$conn->close();

// Cetak PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_barang_masuk.pdf', ['Attachment' => false]);
