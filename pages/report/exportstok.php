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
$jenis  = $_GET['jenis'] ?? '';

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




$sql = "SELECT 
    b.nama_barang,
    j.jenis_barang, -- atau ubah jika ada perbedaan
    b.nama_barang as spesifikasi,
    b.satuan,
    s.stok
FROM stok s
JOIN barang b ON b.id_barang = s.id_barang
JOIN jenis j ON j.id_jenis = b.id_jenis
WHERE 1=1";


if (!empty($jenis)) {
    $sql .= " AND   b.id_jenis = '$jenis'";
}

$sql .= " ORDER BY b.nama_barang DESC";

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

<div class="title">Laporan Stok Barang</div>
<div style="margin-top: 5px;">
    <strong>Jenis:</strong> ' . $jenisText . '<br>

</div>


<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Spesifikasi</th>
            <th>Satuan</th>
            <th>Stok</th>
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
            <td>' . $row['spesifikasi'] . '</td>
            <td>' . $row['satuan'] . '</td>
            <td>' . $row['stok'] . '</td>
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
$dompdf->stream('laporan_stok_barang.pdf', ['Attachment' => false]);