<?php
$koneksi = mysqli_connect("localhost", "root", "", "siperba");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Filter berdasarkan id_supplier jika disediakan
$filter_supplier = "";
if (isset($_GET['id_supplier']) && $_GET['id_supplier'] !== '') {
    $id_supplier = $_GET['id_supplier'];
    if ($id_supplier !== 'semua') {
        $filter_supplier = " AND barang_masuk.id_supplier = '$id_supplier'";
    }
}

$filter_tanggal = "";
if (isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_selesai']) && $_GET['tanggal_mulai'] !== '' && $_GET['tanggal_selesai'] !== '') {
    $tanggal_mulai = $_GET['tanggal_mulai'];
    $tanggal_selesai = $_GET['tanggal_selesai'];
    $filter_tanggal = " AND DATE(barang_masuk.tanggal_masuk) BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

// Query untuk mengambil data dengan filter
$selectSQL = "SELECT barang_masuk.*, supplier.nama_supplier, pegawai.nama_pegawai, barang.nama_barang, barang.kode_barang
              FROM barang_masuk
              LEFT JOIN supplier ON barang_masuk.id_supplier = supplier.id_supplier
              LEFT JOIN pegawai ON barang_masuk.id_pegawai = pegawai.id_pegawai
              LEFT JOIN barang ON barang_masuk.id_barang = barang.id_barang
              WHERE 1=1 $filter_supplier $filter_tanggal";

$resultSet = mysqli_query($koneksi, $selectSQL);

if (!$resultSet) {
    die("Error in SQL query: " . mysqli_error($koneksi));
}
?>

<style type="text/css">
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid;
        padding: 8px;
        font-size: 8px;
    }

    th {
        text-align: center;
        background-color: #ddd;
    }

    td.angka {
        text-align: right;
    }

    td.info {
        border: 0px;
        padding: 2px;
        font-size: 9px;
    }

    td.tebal {
        font-weight: bold;
    }

    td.spasi-ttd {
        border: 0px;
        height: 32px;
    }

    .center {
        text-align: center;
        padding-bottom: 15px;
    }

    .judul {
        font-size: 10px;
        font-weight: bold;
        display: table;
        margin: 0 auto;
        margin-bottom: 10px;
    }

    #logo {
        text-align: center;
        margin-bottom: 15px;
        border-bottom: 1px solid;
        padding-bottom: 10px;
    }

    #logo img {
        height: 80px;
    }

    #tabel-data {
        margin-bottom: 20px;
        text-align: center;
    }
</style>

<!-- Logo -->
<div id="logo">
    <img src="C:/xampp/htdocs/siperba/assets/images/dinas.png" alt="Logo BPS">
</div>

<div class="center">
    <span class="judul">Laporan Barang Masuk Pada Dinas Pariwisata</span>
</div>

<table id="tabel-data">
    <thead>
        <tr>
            <th>No</th>
            <th>Supplier</th>
            <th>Penerima</th>
            <th>Nomor Masuk</th>
            <th>Tanggal Masuk</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Kondisi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($resultSet)) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
                <td><?= htmlspecialchars($row['nama_pegawai']) ?></td>
                <td><?= htmlspecialchars($row['nomor_masuk']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_masuk']) ?></td>
                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td class="angka"><?= number_format($row['jumlah']) ?></td>
                <td class="angka"><?= number_format($row['harga_satuan'], 2) ?></td>
                <td class="angka"><?= number_format($row['total'], 2) ?></td>
                <td><?= htmlspecialchars($row['kondisi']) ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<br><br>

<table style="border: none !important; border-collapse: collapse !important;" border="0">
    <colgroup>
        <col style="width: 70%">
        <col style="width: 30%">
    </colgroup>
    <tbody>
        <tr>
            <td class="info"></td>
            <td class="info" style="text-align: center;">Martapura, <?= date('d F Y') ?></td>
        </tr>
        <tr>
            <td rowspan="1" class="spasi-ttd"></td>
        </tr>
        <tr>
            <td class="info"></td>
            <td class="info" style="text-align: center;">
                <u>Abdullah Riva'i, SE</u><br>
                Kepala BPS Kab.Banjar
            </td>
        </tr>
    </tbody>
</table>