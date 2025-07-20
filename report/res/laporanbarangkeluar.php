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
        /* Ukuran teks di dalam sel tabel */
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
        /* Ukuran teks di dalam sel info */
        font-size: 9px;
        /* Ubah ukuran teks kop surat */
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
    <span class="judul">Laporan Barang Keluar Pada Dinas Pariwisata</span>
</div>

<table id="tabel-data">
    <colgroup>
        <col style="width: 3%" class="angka">
        <col style="width: 10%">
        <col style="width: 8%">
        <col style="width: 20%">
        <col style="width: 20%">
        <col style="width: 8%">
        <col style="width: 5%">
        <col style="width: 15%">
        <col style="width: 11%">
    </colgroup>
    <thead>
        <tr>
            <th>NO</th>
            <th>Nomor Keluar</th>
            <th>Tanggal Keluar</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
            <th>Pegawai</th>
            <th>Divisi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $koneksi = mysqli_connect("localhost", "root", "", "siperba");
        if (!$koneksi) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }
        // Filter berdasarkan id_divisi jika disediakan
        $filter_divisi = "";
        if (isset($_GET['id_divisi']) && $_GET['id_divisi'] !== '') {
            $id_divisi = $_GET['id_divisi'];
            if ($id_divisi !== 'semua') {
                $filter_divisi = " AND permintaan.id_divisi = '$id_divisi'";
            }
        }

        $filter_tanggal = "";
        if (isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_selesai']) && $_GET['tanggal_mulai'] !== '' && $_GET['tanggal_selesai'] !== '') {
            $tanggal_mulai = $_GET['tanggal_mulai'];
            $tanggal_selesai = $_GET['tanggal_selesai'];

            $filter_tanggal = " AND DATE(barang_keluar.tanggal_keluar) BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
        }


        $selectSQL = "SELECT barang_keluar.*, barang.nama_barang,barang.kode_barang, pegawai.nama_pegawai, divisi.nama_divisi, permintaan_detail.jumlah
    FROM barang_keluar
    LEFT JOIN permintaan_detail ON barang_keluar.id_permintaan_detail = permintaan_detail.id_permintaan_detail
    LEFT JOIN barang ON permintaan_detail.id_barang = barang.id_barang
    LEFT JOIN permintaan ON permintaan_detail.id_permintaan = permintaan.id_permintaan
    LEFT JOIN pegawai ON permintaan.id_pegawai = pegawai.id_pegawai
    LEFT JOIN divisi ON pegawai.id_divisi = divisi.id_divisi
    WHERE 1=1 $filter_divisi $filter_tanggal";
        $resultSet = mysqli_query($koneksi, $selectSQL);

        // Tambahkan penanganan kesalahan
        if (!$resultSet) {
            die("Error in SQL query: " . mysqli_error($koneksi));
        }

        $no = 1;
        while ($row = mysqli_fetch_assoc($resultSet)) {

        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nomor_keluar'] ?></td>
                <td><?= $row['tanggal_keluar'] ?></td>
                <td><?= $row['kode_barang'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['kondisi'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['nama_pegawai'] ?></td>
                <td><?= $row['nama_divisi'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<br>
<br>
<table>
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