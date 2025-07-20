<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "siperba");

// Filter divisi dan tanggal
$filter_divisi = "";
$filter_tanggal = "";
$id_divisi = isset($_GET['id_divisi']) ? $_GET['id_divisi'] : '';
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

if ($id_divisi !== '' && $id_divisi !== 'semua') {
    $filter_divisi = " permintaan.id_divisi = '$id_divisi'";
}

if ($tanggal_mulai !== '' && $tanggal_selesai !== '') {
    $filter_tanggal = " barang_keluar.tanggal_keluar BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

$filter_where = "";
if ($filter_divisi && $filter_tanggal) {
    $filter_where = "WHERE $filter_divisi AND $filter_tanggal";
} elseif ($filter_divisi) {
    $filter_where = "WHERE $filter_divisi";
} elseif ($filter_tanggal) {
    $filter_where = "WHERE $filter_tanggal";
}

$selectSQL = "SELECT barang_keluar.*, barang.nama_barang, pegawai.nama_pegawai, divisi.nama_divisi, permintaan_detail.jumlah
FROM barang_keluar
LEFT JOIN permintaan_detail ON barang_keluar.id_permintaan_detail = permintaan_detail.id_permintaan_detail
LEFT JOIN barang ON permintaan_detail.id_barang = barang.id_barang
LEFT JOIN permintaan ON permintaan_detail.id_permintaan = permintaan.id_permintaan
LEFT JOIN pegawai ON permintaan.id_pegawai = pegawai.id_pegawai
LEFT JOIN divisi ON pegawai.id_divisi = divisi.id_divisi
$filter_where";

$resultSet = mysqli_query($koneksi, $selectSQL);

if (!$resultSet) {
    die("Error in SQL query: " . mysqli_error($koneksi));
}
?>

<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-4">
                <h3>Data Barang Keluar</h3>
            </div>
            <div class="col-md-8">
                <form id="filterForm" method="GET">
                    <div class="input-group">
                        <?php
                        $selectDivisiSQL = "SELECT * FROM divisi ORDER BY id_divisi";
                        $resultSetDivisi = mysqli_query($koneksi, $selectDivisiSQL);
                        ?>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggalMulai" value="<?= $tanggal_mulai; ?>">
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggalSelesai" value="<?= $tanggal_selesai; ?>">
                        <select class="form-select" name="id_divisi" id="divisiFilter" required>
                            <option value="">-- Pilih Divisi --</option>
                            <option value="semua" <?= ($id_divisi == 'semua') ? 'selected' : ''; ?>>Semua</option>
                            <?php while ($rowDivisi = mysqli_fetch_assoc($resultSetDivisi)) {
                                $selected = ($id_divisi == $rowDivisi['id_divisi']) ? 'selected' : '';
                                echo "<option value='{$rowDivisi['id_divisi']}' $selected>{$rowDivisi['nama_divisi']}</option>";
                            } ?>
                        </select>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <a href="#" class="btn btn-info" onclick="handlePrintButtonClick()">
                            <i class="fa fa-print"></i> Cetak
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>Nomor Keluar</th>
                            <th>Tanggal Keluar</th>
                            <th>Nama Barang</th>
                            <th>Kondisi</th>
                            <th>Jumlah</th>
                            <th>Pegawai</th>
                            <th>Divisi</th>
                            <th width="200">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($resultSet)) { ?>
                            <tr class="align-middle">
                                <td><?= $no++ ?></td>
                                <td><?= $row['nomor_keluar'] ?></td>
                                <td><?= $row['tanggal_keluar'] ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><?= $row['kondisi'] ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td><?= $row['nama_pegawai'] ?></td>
                                <td><?= $row['nama_divisi'] ?></td>
                                <td>
                                    <a href="#" onclick="konfirmasi('?page=barangkeluarhapus&id_barang_keluar=<?= $row['id_barang_keluar'] ?>');" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var selectedDivisiId = document.getElementById('divisiFilter').value;
        var tanggalMulai = document.getElementById('tanggalMulai').value;
        var tanggalSelesai = document.getElementById('tanggalSelesai').value;
        var currentUrl = new URL(window.location.href);

        currentUrl.searchParams.set('id_divisi', selectedDivisiId);
        if (tanggalMulai) currentUrl.searchParams.set('tanggal_mulai', tanggalMulai);
        if (tanggalSelesai) currentUrl.searchParams.set('tanggal_selesai', tanggalSelesai);

        window.location.href = currentUrl.href;
    });

    function handlePrintButtonClick() {
        var selectedDivisiId = document.getElementById('divisiFilter').value;
        var tanggalMulai = document.getElementById('tanggalMulai').value;
        var tanggalSelesai = document.getElementById('tanggalSelesai').value;
        var printUrl = "report/laporanbarangkeluar.php?id_divisi=" + selectedDivisiId + "&tanggal_mulai=" + tanggalMulai + "&tanggal_selesai=" + tanggalSelesai;

        window.open(printUrl, '_blank');
    }
</script>