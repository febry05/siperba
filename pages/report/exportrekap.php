<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
session_start(); 


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
$db   = "siperba";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


// Ambil filter dari form
$startdate = $_GET['startdate'] ?? '';
$enddate = $_GET['enddate'] ?? '';
// $tgl = date('Y-m', strtotime($tanggal));
$jenis  = $_GET['jenis'] ?? '';
$usercetak = $_SESSION["nama_pegawai"];

// Ambil nama jenis dari DB jika tersedia
$jenisText = 'Semua';
if (!empty($jenis)) {
    $stmtJenis = $conn->prepare("SELECT jenis_barang FROM jenis WHERE id_jenis = ?");
    $stmtJenis->bind_param("s", $jenis);
    $stmtJenis->execute();
    $resultJenis = $stmtJenis->get_result();
    if ($resultJenis->num_rows > 0) {
        $rowJenis = $resultJenis->fetch_assoc();
        $jenisText = $rowJenis['jenis_barang'];
    } else {
        $jenisText = 'Tidak Diketahui';
    }
    $stmtJenis->close();
}

// Query data
$sql = "SELECT 
    b.nama_barang,
    jb.jenis_barang,
    COALESCE(SUM(bm.jumlah), 0) AS total_masuk,
    COALESCE(SUM(pd.jumlah), 0) AS total_keluar,
    s.stok,
    b.satuan
FROM barang b
LEFT JOIN jenis jb ON jb.id_jenis = b.id_jenis
LEFT JOIN barang_masuk bm ON bm.id_barang = b.id_barang
LEFT JOIN permintaan_detail pd ON pd.id_barang = b.id_barang
LEFT JOIN barang_keluar bk ON bk.id_permintaan_detail = pd.id_permintaan_detail
LEFT JOIN stok s ON s.id_barang = b.id_barang
WHERE 1=1";

// Filter tanggal
if (!empty($startdate)) {
    $sql .= " AND bm.tanggal_masuk BETWEEN '$startdate' AND '$enddate'";
}

// Filter berdasarkan jenis
if (!empty($jenis)) {
    $sql .= " AND b.id_jenis = '$jenis'";
}

$sql .= " GROUP BY b.id_barang, b.nama_barang, jb.jenis_barang, s.stok, b.satuan";
$sql .= " ORDER BY b.nama_barang ASC";

$result = $conn->query($sql);

// Ambil tanggal cetak
$tanggalCetak = date('d M Y');

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
    <div style="position: absolute; top: 20px; right: 40px;" class="logo">
        <img src="' . $logo . '" class="logo" />
    </div>
    <div>Dinas Provinsi Kalimantan Selatan<br>
    Jln Jend A. Yani Km 7,5 Hanyar, Kabupaten Banjar Kode Pos 70654<br>
    Telp (0511) 6795594<br>
    Email : disparprovkalsel</div>
</div>

<div class="title">Laporan Rekap Barang</div>
<div class="row">
        <div class="col-md-6">
            <div style=" margin-top: 10px;">
            <strong>Periode:</strong> ' .  date('d F Y', strtotime($startdate)).' - '. date('d F Y', strtotime($enddate)).' <br>
            <strong>Jenis Barang:</strong> ' . $jenisText . '<br>
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
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Stok Akhir</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . $row['nama_barang'] . '</td>
            <td>' . $row['jenis_barang'] . '</td>
            <td>' . $row['total_masuk'] . '</td>
            <td>' . $row['total_keluar'] . '</td>
            <td>' . $row['stok'] . '</td>
            <td>' . $row['satuan'] . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="7">Data tidak ditemukan</td></tr>';
}

$html .= '
    </tbody>
</table>

<style>
.footer {
    margin-top: 50px;
    text-align: right;
    padding-right: 100px;
}
</style>

<div class="footer">Tertanda</div>
';

$conn->close();

// Export ke PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('laporan_rekap_barang.pdf', ['Attachment' => false]);
