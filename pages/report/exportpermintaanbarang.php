<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;

session_start(); 

$logoPath = __DIR__ . '/../../assets/images/wonderfull.jpg';
if (file_exists($logoPath)) {
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logo = 'data:image/png;base64,' . $logoBase64;
} else {
    $logo = '';
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
$status  = $_GET['status'] ?? '';

$usercetak = $_SESSION["nama_pegawai"];



// Ubah status ke teks
$statusText = 'Semua';
if ($status !== '') {
    $statusText = match ($status) {
        '0' => 'Menunggu Persetujuan',
        '1' => 'Telah Disetujui',
        '2' => 'Tidak Disetujui',
        '3' => 'Selesai',
        default => 'Tidak Diketahui',
    };
}

// SQL query
$sql = "SELECT
    p.id_permintaan,
    p.tgl_permintaan,
    p.no_surat,
    b.nama_barang,
    j.jenis_barang,
    pd.jumlah,
    b.satuan,
    pg.nama_pegawai,
    d.nama_divisi,
    pd.status
FROM permintaan p
JOIN permintaan_detail pd ON pd.id_permintaan = p.id_permintaan
JOIN barang b ON b.id_barang = pd.id_barang
JOIN jenis j ON j.id_jenis = b.id_jenis
JOIN pegawai pg ON pg.id_pegawai = p.id_pegawai
JOIN divisi d ON d.id_divisi = pg.id_divisi
WHERE 1=1";



// Filter tanggal
if (!empty($startdate)) {
    $sql .= " AND p.tgl_permintaan BETWEEN '$startdate' AND '$enddate'";
}

// Filter status
if ($status !== '') {
    $sql .= " AND pd.status = '$status'";
}   

$sql .= " ORDER BY p.tgl_permintaan DESC";



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
    Jln Jend A. Yani Km 7,5 Hanyar, Kabupaten Banjar Kode Pos 70654<br>
    Telp (0511) 6795594<br>
    Email : disparprovkalsel</div>
</div>

<div class="title">Laporan Permintaan Barang</div>
    <div class="row">
        <div class="col-md-6">
            <div style=" margin-top: 10px;">
            <strong>Periode:</strong> ' .  date('d F Y', strtotime($enddate)).' - '. date('d F Y', strtotime($enddate)).' <br>
            <strong>Status:</strong> ' . $statusText . '<br>
        </div>
         <div class="col-md-6" style="position: absolute; top: 100px; right: 40px;" >
            <div style=" margin-top: 5px;">
            <strong>Tanggal Cetak:</strong> ' . DATE('d F Y') . '<br>
            <strong>User Pencetak:</strong> ' . $usercetak. '<br>
        </div>
        </div>
    </div>
</div>


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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statuss = match ($row['status']) {
            '0' => '<span class="text-warning">Menunggu Persetujuan</span>',
            '1' => '<span class="text-primary">Telah Disetujui</span>',
            '2' => '<span class="text-danger">Tidak Disetujui</span>',
            '3' => '<span class="text-success">Selesai</span>',
            default => '<span class="text-secondary">Tidak Diketahui</span>',
        };

        $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . date('d M Y', strtotime($row['tgl_permintaan'])) . '</td>
            <td>' . $row['no_surat'] . '</td>
            <td>' . $row['nama_barang'] . '</td>
            <td>' . $row['jenis_barang'] . '</td>
            <td>' . $row['jumlah'] . '</td>
            <td>' . $row['satuan'] . '</td>
            <td>' . $statuss . '</td>
            <td>' . $row['nama_pegawai'] . '</td>
            <td>' . $row['nama_divisi'] . '</td>
            <td>Aktif</td>
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
    padding-right: 100px;
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
$dompdf->stream('laporan_permintaan_barang.pdf', ['Attachment' => false]);
