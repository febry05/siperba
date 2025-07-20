<?php
// Fungsi untuk mengubah angka menjadi format Rupiah
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

// Filter supplier dan range tanggal
$filter_supplier = "";
$filter_tanggal = "";
$id_supplier = '';
$tanggal_mulai = '';
$tanggal_selesai = '';

if (isset($_GET['id_supplier']) && $_GET['id_supplier'] !== '') {
    $id_supplier = $_GET['id_supplier'];
    if ($id_supplier !== 'semua') {
        $filter_supplier = "barang_masuk.id_supplier = '$id_supplier'";
    }
}

if (isset($_GET['tanggal_mulai']) && isset($_GET['tanggal_selesai']) && $_GET['tanggal_mulai'] !== '' && $_GET['tanggal_selesai'] !== '') {
    $tanggal_mulai = $_GET['tanggal_mulai'];
    $tanggal_selesai = $_GET['tanggal_selesai'];
    $filter_tanggal = "barang_masuk.tanggal_masuk BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

$filter_where = "";
if ($filter_supplier && $filter_tanggal) {
    $filter_where = "WHERE $filter_supplier AND $filter_tanggal";
} elseif ($filter_supplier) {
    $filter_where = "WHERE $filter_supplier";
} elseif ($filter_tanggal) {
    $filter_where = "WHERE $filter_tanggal";
}

$selectSQL = "SELECT barang_masuk.*, supplier.nama_supplier, pegawai.nama_pegawai, barang.nama_barang, barang.kode_barang
    FROM barang_masuk
    LEFT JOIN supplier ON barang_masuk.id_supplier = supplier.id_supplier
    LEFT JOIN pegawai ON barang_masuk.id_pegawai = pegawai.id_pegawai
    LEFT JOIN barang ON barang_masuk.id_barang = barang.id_barang
    $filter_where";

$resultSet = mysqli_query($koneksi, $selectSQL);

if (!$resultSet) {
    die("Error in SQL query: " . mysqli_error($koneksi));
}

?>

<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-3">
                <h3>Barang Masuk</h3>
            </div>
            <div class="col-md-9">
                <form id="filterForm" method="GET">
                    <div class="input-group">
                        <?php
                        $selectSupplierSQL = "SELECT * FROM supplier ORDER BY id_supplier";
                        $resultSetSupplier = mysqli_query($koneksi, $selectSupplierSQL);
                        ?>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggalMulai"
                            value="<?= $tanggal_mulai; ?>">
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggalSelesai"
                            value="<?= $tanggal_selesai; ?>">
                        <select class="form-select" name="id_supplier" id="supplierFilter">
                            <option value="">-- Pilih Supplier --</option>
                            <option value="semua" <?= ($id_supplier == 'semua') ? 'selected' : ''; ?>>Semua</option>
                            <?php while ($rowSupplier = mysqli_fetch_assoc($resultSetSupplier)) { ?>
                            <option value="<?= $rowSupplier['id_supplier']; ?>"
                                <?= ($id_supplier == $rowSupplier['id_supplier']) ? 'selected' : ''; ?>>
                                <?= $rowSupplier['nama_supplier']; ?>
                            </option>
                            <?php } ?>
                        </select>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <a href="#" class="btn btn-info" onclick="handlePrintButtonClick()">
                            <i class="fa fa-print"></i> Cetak
                        </a>
                        <a href="?page=barangmasuktambah" class="btn btn-success float-end me-1">
                            <i class="fa fa-plus-circle"></i> Tambah
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
                <table class="table bg-white rounded shadow-sm table-hover table-lg" id="example">
                    <thead>
                        <tr>
                            <th width="25">NO</th>
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
                            <th width="75">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = mysqli_fetch_assoc($resultSet)) { ?>
                        <tr class="align-middle">
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_supplier']; ?></td>
                            <td><?= $row['nama_pegawai']; ?></td>
                            <td><?= $row['nomor_masuk']; ?></td>
                            <td><?= $row['tanggal_masuk']; ?></td>
                            <td><?= $row['kode_barang']; ?></td>
                            <td><?= $row['nama_barang']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= rupiah($row['harga_satuan']); ?></td>
                            <td><?= rupiah($row['total']); ?></td>
                            <td><?= $row['kondisi']; ?></td>
                            <td>
                                <a href="?page=barangmasukubah&id_barang_masuk=<?= $row['id_barang_masuk']; ?>"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                    onclick="konfirmasi('?page=barangmasukhapus&id_barang_masuk=<?= $row['id_barang_masuk']; ?>');"
                                    class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
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
    var selectedSupplierId = document.getElementById('supplierFilter').value;
    var tanggalMulai = document.getElementById('tanggalMulai').value;
    var tanggalSelesai = document.getElementById('tanggalSelesai').value;
    var currentUrl = new URL(window.location.href);

    currentUrl.searchParams.set('id_supplier', selectedSupplierId);
    if (tanggalMulai) currentUrl.searchParams.set('tanggal_mulai', tanggalMulai);
    if (tanggalSelesai) currentUrl.searchParams.set('tanggal_selesai', tanggalSelesai);

    window.location.href = currentUrl.href;
});

function handlePrintButtonClick() {
    var selectedSupplierId = document.getElementById('supplierFilter').value;
    var tanggalMulai = document.getElementById('tanggalMulai').value;
    var tanggalSelesai = document.getElementById('tanggalSelesai').value;
    var printUrl = "report/laporanbarangmasuk.php?id_supplier=" + selectedSupplierId + "&tanggal_mulai=" +
        tanggalMulai + "&tanggal_selesai=" + tanggalSelesai;

    window.open(printUrl, '_blank');
}
</script>