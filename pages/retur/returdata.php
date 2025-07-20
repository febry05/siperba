<?php
// Fungsi untuk mengubah angka menjadi format Rupiah
function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "siperba");

// Filter supplier dan tanggal
$filter_supplier = "";
$filter_tanggal = "";
$id_supplier = isset($_GET['id_supplier']) ? $_GET['id_supplier'] : '';
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '';
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : '';

// Filter berdasarkan supplier
if ($id_supplier !== '' && $id_supplier !== 'semua') {
    $filter_supplier = "barang_masuk.id_supplier = '$id_supplier'";
}

// Filter berdasarkan range tanggal
if ($tanggal_mulai !== '' && $tanggal_selesai !== '') {
    $filter_tanggal = "barang_masuk.tanggal_masuk BETWEEN '$tanggal_mulai' AND '$tanggal_selesai'";
}

// Menggabungkan filter
$filter_where = "WHERE barang_masuk.kondisi = 'RUSAK'"; // Filter kondisi rusak sebagai syarat utama

if ($filter_supplier && $filter_tanggal) {
    $filter_where .= " AND $filter_supplier AND $filter_tanggal";
} elseif ($filter_supplier) {
    $filter_where .= " AND $filter_supplier";
} elseif ($filter_tanggal) {
    $filter_where .= " AND $filter_tanggal";
}

// Query untuk mengambil data barang rusak dengan filter yang diterapkan
$selectSQL = "SELECT barang_masuk.*, supplier.nama_supplier, pegawai.nama_pegawai, barang.nama_barang
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
                <h3>Retur Barang Rusak</h3>
            </div>
            <div class="col-md-9">
                <!-- Form untuk filter -->
                <form id="filterForm" method="GET">
                    <div class="input-group">
                        <?php
                        // Ambil data supplier
                        $selectSupplierSQL = "SELECT * FROM supplier ORDER BY id_supplier";
                        $resultSetSupplier = mysqli_query($koneksi, $selectSupplierSQL);
                        ?>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggalMulai" value="<?= $tanggal_mulai; ?>">
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggalSelesai" value="<?= $tanggal_selesai; ?>">
                        <select class="form-select" name="id_supplier" id="supplierFilter" required>
                            <option value="">-- Pilih Supplier --</option>
                            <option value="semua" <?php echo (isset($_GET['id_supplier']) && $_GET['id_supplier'] == 'semua') ? 'selected' : ''; ?>>Semua</option>
                            <?php
                            while ($rowSupplier = mysqli_fetch_assoc($resultSetSupplier)) {
                                $selected = ($_GET['id_supplier'] == $rowSupplier['id_supplier']) ? 'selected' : '';
                                echo "<option value='{$rowSupplier['id_supplier']}' $selected>{$rowSupplier['nama_supplier']}</option>";
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-primary" type="button"> <!-- Menggunakan type="submit" untuk tombol filter -->
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
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Kondisi</th>
                            <th width="75">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($resultSet)) {
                        ?>
                            <tr class="align-middle">
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_supplier'] ?></td>
                                <td><?= $row['nama_pegawai'] ?></td>
                                <td><?= $row['nomor_masuk'] ?></td>
                                <td><?= $row['tanggal_masuk'] ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td><?= rupiah($row['harga_satuan']) ?></td>
                                <td><?= rupiah($row['total']) ?></td>
                                <td><?= $row['kondisi'] ?></td>
                                <td>
                                    <a href="?page=barangubah&id_barang=<?= $row['id_barang'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="konfirmasi('?page=barangmasukhapus&id_barang_masuk=<?= $row['id_barang_masuk'] ?>');" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
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
<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Menghentikan perilaku bawaan formulir untuk mengirimkan permintaan
        var selectedSupplierId = document.getElementById('supplierFilter').value;
        var tanggalMulai = document.getElementById('tanggalMulai').value;
        var tanggalSelesai = document.getElementById('tanggalSelesai').value;
        var currentUrl = new URL(window.location.href);

        // Update parameter id_supplier pada URL
        currentUrl.searchParams.set('id_supplier', selectedSupplierId);
        if (tanggalMulai) currentUrl.searchParams.set('tanggal_mulai', tanggalMulai);
        if (tanggalSelesai) currentUrl.searchParams.set('tanggal_selesai', tanggalSelesai);

        // Mengarahkan ke URL dengan filter yang diterapkan
        window.location.href = currentUrl.href;
    });

    // Fungsi untuk menangani aksi saat tombol cetak ditekan
    function handlePrintButtonClick() {
        var selectedSupplierId = document.getElementById('supplierFilter').value;
        var tanggalMulai = document.getElementById('tanggalMulai').value;
        var tanggalSelesai = document.getElementById('tanggalSelesai').value;
        var printUrl = "report/laporanretur.php?id_supplier=" + selectedSupplierId + "&tanggal_mulai=" + tanggalMulai + "&tanggal_selesai=" + tanggalSelesai;

        // Membuka URL cetak dalam jendela baru
        window.open(printUrl, '_blank');
    }
</script>