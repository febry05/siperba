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
$jenis  = $_GET['jenis'] ?? '';



$sql = "SELECT 
    p.id_pegawai,
    p.nama_pegawai,
    p.nip,
    d.nama_divisi
FROM pegawai p
LEFT JOIN divisi d ON d.id_divisi = p.id_divisi
WHERE 1=1
ORDER BY p.nama_pegawai ASC
";



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

<div class="title">Laporan Pegawai</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Divisi</th>
            <th>Kontak</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . $row['nama_pegawai'] . '</td>
            <td>' . $row['nip'] . '</td>
            <td></td>
            <td>' . $row['nama_divisi'] . '</td>
            <td></td>
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