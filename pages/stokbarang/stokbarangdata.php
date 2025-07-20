<?php
// Fungsi untuk mengubah angka menjadi format Rupiah
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

// Filter supplier dan tanggal
$filter_jenis = "";
$filter_tanggal = "";
$id_jenis = '';
$tgl_mulai = '';
$tgl_selesai = '';

if (isset($_GET['id_jenis']) && $_GET['id_jenis'] !== '') {
    $id_jenis = $_GET['id_jenis'];
    if ($id_jenis !== 'semua') {
        $filter_jenis = " AND barang.id_jenis = '$id_jenis'";
    }
}

if (!empty($_GET['tgl_mulai']) && !empty($_GET['tgl_selesai'])) {
    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_selesai = $_GET['tgl_selesai'];
    $filter_tanggal = " AND stok.tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

$selectSQL = "SELECT stok.*, barang.*, barang_masuk.*, jenis.jenis_barang 
FROM stok 
JOIN barang ON stok.id_barang = barang.id_barang 
JOIN barang_masuk ON stok.id_barang_masuk = barang_masuk.id_barang_masuk 
JOIN jenis ON barang.id_jenis = jenis.id_jenis
WHERE 1=1 $filter_jenis $filter_tanggal";

$resultSet = mysqli_query($koneksi, $selectSQL);

if (!$resultSet) {
    die("Error in SQL query: " . mysqli_error($koneksi));
}
?>
<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-4">
                <h3>Data Stok Barang</h3>
            </div>
            <div class="col-md-8">
                <!-- Form untuk filter -->
                <form id="filterForm" method="GET">
                    <div class="input-group">
                        <?php
                        $selectJenisSQL = "SELECT * FROM jenis ORDER BY id_jenis";
                        $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                        ?>
                        <input type="date" class="form-control" name="tgl_mulai" id="tglMulai" value="<?= $tgl_mulai ?>">
                        <input type="date" class="form-control" name="tgl_selesai" id="tglSelesai" value="<?= $tgl_selesai ?>">
                        <select class="form-select" name="id_jenis" id="jenisFilter" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="semua" <?php echo ($id_jenis == 'semua') ? 'selected' : ''; ?>>Semua</option>
                            <?php
                            while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                                $selected = ($id_jenis == $rowJenis['id_jenis']) ? 'selected' : '';
                                echo "<option value='{$rowJenis['id_jenis']}' $selected>{$rowJenis['jenis_barang']}</option>";
                            }
                            ?>
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
<div id="tengah">
    <script>
        // konfirmasi()
        // pesanToast()
    </script>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>Tanggal</th>
                            <th>Kode Barang</th>
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($resultSet)) {
                            $tanggal = !empty($row['tanggal']) ? $row['tanggal'] : $row['tanggal_masuk'];
                        ?>
                            <tr class="align-middle">
                                <td><?= $no++ ?></td>
                                <td><?= $tanggal ?></td>
                                <td><?= $row['kode_barang'] ?></td>
                                <td><?= $row['jenis_barang'] ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><?= $row['satuan'] ?></td>
                                <td><?= $row['stok'] ?></td>
                                <td><?= $row['kondisi'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var selectedJenisId = document.getElementById('jenisFilter').value;
        var tglMulai = document.getElementById('tglMulai').value;
        var tglSelesai = document.getElementById('tglSelesai').value;
        var currentUrl = new URL(window.location.href);

        currentUrl.searchParams.set('id_jenis', selectedJenisId);
        currentUrl.searchParams.set('tgl_mulai', tglMulai);
        currentUrl.searchParams.set('tgl_selesai', tglSelesai);

        window.location.href = currentUrl.href;
    });

    function handlePrintButtonClick() {
        var selectedJenisId = document.getElementById('jenisFilter').value;
        var tglMulai = document.getElementById('tglMulai').value;
        var tglSelesai = document.getElementById('tglSelesai').value;
        var printUrl = "report/laporanstokbarang.php?id_jenis=" + selectedJenisId + "&tgl_mulai=" + tglMulai + "&tgl_selesai=" + tglSelesai;

        window.open(printUrl, '_blank');
    }
</script>