<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "siperba");

// Filter permintaan dan tanggal
$filter_permintaan = "";
$filter_tanggal = "";
$id_permintaan = isset($_GET['id_permintaan']) ? $_GET['id_permintaan'] : '';
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

// Filter berdasarkan id_permintaan
if ($id_permintaan !== '' && $id_permintaan !== 'semua') {
    $filter_permintaan = "permintaan.id_permintaan = '$id_permintaan'";
}

// Filter berdasarkan range tanggal
if ($tanggal_mulai !== '' && $tanggal_selesai !== '') {
    $filter_tanggal = "permintaan.tgl_permintaan BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

// Menggabungkan filter
$filter_where = "";
if ($filter_permintaan && $filter_tanggal) {
    $filter_where = "WHERE $filter_permintaan AND $filter_tanggal";
} elseif ($filter_permintaan) {
    $filter_where = "WHERE $filter_permintaan";
} elseif ($filter_tanggal) {
    $filter_where = "WHERE $filter_tanggal";
}

// Query dengan filter
$selectSQL = "SELECT permintaan.*, pegawai.nama_pegawai, divisi.nama_divisi
              FROM permintaan
              JOIN pegawai ON permintaan.id_pegawai = pegawai.id_pegawai
              JOIN divisi ON pegawai.id_divisi = divisi.id_divisi
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
                <h3>Data Permintaan Barang</h3>
            </div>
            <div class="col-md-8">
                <!-- Form untuk filter -->
                <form id="filterForm" method="GET">
                    <div class="input-group">
                        <?php
                        // Ambil data permintaan
                        $selectPermintaanSQL = "SELECT p.*, pg.nama_pegawai FROM permintaan p JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai ORDER BY p.id_permintaan";
                        $resultSetPermintaan = mysqli_query($koneksi, $selectPermintaanSQL);

                        if (!$resultSetPermintaan) {
                            die("Error in SQL query: " . mysqli_error($koneksi));
                        }
                        ?>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggalMulai"
                            value="<?= $tanggal_mulai; ?>">
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggalSelesai"
                            value="<?= $tanggal_selesai; ?>">

                        <select class="form-select" name="id_permintaan" id="permintaanFilter" required>
                            <option value="">-- Pilih Permintaan --</option>
                            <option value="semua"
                                <?php echo (isset($_GET['id_permintaan']) && $_GET['id_permintaan'] == 'semua') ? 'selected' : ''; ?>>
                                Semua</option>
                            <?php
                            while ($rowPermintaan = mysqli_fetch_assoc($resultSetPermintaan)) {
                                $selected = ($_GET['id_permintaan'] == $rowPermintaan['id_permintaan']) ? 'selected' : '';
                                echo "<option value='{$rowPermintaan['id_permintaan']}' $selected>{$rowPermintaan['nama_pegawai']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-primary">
                            <!-- Menggunakan type="submit" untuk tombol filter -->
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <a href="#" class="btn btn-info" onclick="handlePrintButtonClick()">
                            <i class="fa fa-print"></i> Cetak
                        </a>
                        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Pegawai") : ?>
                        <a href="?page=permintaantambah" class="btn btn-success float-end">
                            <i class="fa fa-plus-circle"></i> Tambah
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="tengah">

</div>

<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>Tanggal Permintaan</th>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Nomor Surat</th>
                            <th>File Surat</th>
                            <th width="200">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($resultSet)) {
                        ?>
                        <tr class="align-middle">
                            <td><?= $no++ ?></td>
                            <td><?= $row['tgl_permintaan'] ?></td>
                            <td><?= $row['nama_pegawai'] ?></td>
                            <td><?= $row['nama_divisi'] ?></td>
                            <td><?= $row['no_surat'] ?></td>
                            <td><?php if($row['file']){?><a href="<?php echo "uploads/".$row['file'] ?>" target="_blank"
                                    title="Lihat" class="btn btn-primary"><i class="fa fa-file"></i>
                                </a> <?php }else{
                                    echo 'Belum Upload';
                                } ?>
                            </td>
                            <td>
                                <a href="?page=permintaandetail&id_permintaan=<?= $row['id_permintaan'] ?>"
                                    class="btn btn-sm btn-dark">
                                    <i class="fa fa-info-circle"></i> Detail
                                </a>
                            </td>
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



<?php
    while ($row = mysqli_fetch_assoc($resultSet)) {
    ?>
<!-- Modal -->
<div class="modal fade" id="filemodal<?= $row['id_permintaan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Preview Surat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>

<script>
document.getElementById('filterForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var selectedPermintaanId = document.getElementById('permintaanFilter').value;
    var tanggalMulai = document.getElementById('tanggalMulai').value;
    var tanggalSelesai = document.getElementById('tanggalSelesai').value;
    var currentUrl = new URL(window.location.href);

    currentUrl.searchParams.set('id_permintaan', selectedPermintaanId);
    if (tanggalMulai) currentUrl.searchParams.set('tanggal_mulai', tanggalMulai);
    if (tanggalSelesai) currentUrl.searchParams.set('tanggal_selesai', tanggalSelesai);
    window.location.href = currentUrl.href;
});

function handlePrintButtonClick() {
    var selectedPermintaanId = document.getElementById('permintaanFilter').value;
    var tanggalMulai = document.getElementById('tanggalMulai').value;
    var tanggalSelesai = document.getElementById('tanggalSelesai').value;
    var printUrl = "report/laporanpermintaanbarang.php?id_permintaan=" + selectedPermintaanId + "&tanggal_mulai=" +
        tanggalMulai + "&tanggal_selesai=" + tanggalSelesai;
    window.open(printUrl, '_blank');
}
</script>