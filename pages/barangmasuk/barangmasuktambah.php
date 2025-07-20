<?php
// Fungsi untuk mengubah angka menjadi format Rupiah
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

$tahunSaatIni = date('Y');

// Mendapatkan nomor urut untuk nomor_masuk
$selectMaxNomorSQL = "SELECT MAX(RIGHT(nomor_masuk, 4)) AS max_nomor FROM barang_masuk WHERE LEFT(nomor_masuk, 4) = 'BM-$tahunSaatIni'";
$resultMaxNomor = mysqli_query($koneksi, $selectMaxNomorSQL);
$rowMaxNomor = mysqli_fetch_assoc($resultMaxNomor);
$maxNomor = $rowMaxNomor['max_nomor'];

// Menentukan nomor_masuk yang baru
$urutan = $maxNomor + 1;


// Cek apakah nomor_masuk sudah ada, jika iya tambahkan satu
while (true) {
    $nomorMasukBaru = "BM-$tahunSaatIni-" . sprintf('%04d', $urutan);

    // Query untuk mengecek apakah nomor_masuk sudah ada
    $checkExistenceSQL = "SELECT COUNT(*) AS jumlah FROM barang_masuk WHERE nomor_masuk = '$nomorMasukBaru'";
    $resultExistence = mysqli_query($koneksi, $checkExistenceSQL);
    $rowExistence = mysqli_fetch_assoc($resultExistence);

    if ($rowExistence['jumlah'] == 0) {
        break; // Nomor_masuk belum ada, keluar dari loop
    }

    // Nomor_masuk sudah ada, tambahkan satu dan cek lagi
    $urutan++;
}
$id_barang_masuk = "id_barang_masuk";
$id_jenis = "id_jenis";

?>

<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Barang Masuk</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangmasukdata" class="btn btn-primary btn-sm float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        if (isset($_POST['simpan_button'])) {
            $id_supplier = $_POST['id_supplier'];
            $id_pegawai = $_POST['id_pegawai'];
            $nomor_masuk = $nomorMasukBaru;
            $tanggal_masuk = $_POST['tanggal_masuk'];
            $id_barang = $_POST['id_barang'];
            $jumlah = $_POST['jumlah'];
            $harga_satuan = $_POST['harga_satuan'];
            $total = $_POST['total'];
            $kondisi = $_POST['kondisi'];

            // Berhasil memperbarui stok barang, lanjutkan dengan menambahkan data barang masuk
            $insertSQL = "INSERT INTO barang_masuk SET id_supplier='$id_supplier',
            id_pegawai='$id_pegawai',
            nomor_masuk='$nomor_masuk',
            id_barang='$id_barang',
            tanggal_masuk='$tanggal_masuk',
            jumlah='$jumlah',
            harga_satuan='$harga_satuan',
            total='$total',
            kondisi='$kondisi'";
            $resultInsert = mysqli_query($koneksi, $insertSQL);

            if (!$resultInsert) {
                // Handle kesalahan saat menyimpan data barang masuk
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Gagal menyimpan barang masuk: <?= mysqli_error($koneksi) ?>
                </div>
                <?php
            } else {
                // Berhasil memperbarui stok barang dan menyimpan data barang masuk
                // Mengambil id_barang_masuk yang baru saja dimasukkan
                $id_barang_masuk = mysqli_insert_id($koneksi);

                // Memperbarui tanggal di tabel stok
                $updateStokSQL = "UPDATE stok 
                SET tanggal = '$tanggal_masuk' 
                WHERE id_barang = $id_barang";
                $resultUpdateStok = mysqli_query($koneksi, $updateStokSQL);

                if (!$resultUpdateStok) {
                    // Handle kesalahan saat memperbarui tanggal di tabel stok
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Gagal memperbarui tanggal di tabel stok: <?= mysqli_error($koneksi) ?>
                    </div>
                <?php
                }
                // Memperbarui jumlah stok barang
                $updateStokSQL = "UPDATE stok SET stok = stok + $jumlah WHERE id_barang = $id_barang";
                $resultUpdateStok = mysqli_query($koneksi, $updateStokSQL);

                if (!$resultUpdateStok) {
                    // Handle kesalahan saat memperbarui stok barang
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Gagal memperbarui stok barang: <?= mysqli_error($koneksi) ?>
                    </div>
                <?php
                } else {
                    // Berhasil memperbarui stok barang
                ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle"></i>
                        Data berhasil ditambahkan
                    </div>
                    <?php
                }
                // Periksa apakah barang sudah ada dalam stok
                $checkStokSQL = "SELECT * FROM stok WHERE id_barang = $id_barang";
                $resultCheckStok = mysqli_query($koneksi, $checkStokSQL);

                if (mysqli_num_rows($resultCheckStok) == 0) {
                    // Jika barang belum ada dalam stok, tambahkan entri baru ke tabel stok
                    $insertStokSQL = "INSERT INTO stok (id_barang, tanggal, stok, id_barang_masuk) VALUES ($id_barang, '$tanggal_masuk', $jumlah, $id_barang_masuk)";
                    $resultInsertStok = mysqli_query($koneksi, $insertStokSQL);

                    if (!$resultInsertStok) {
                        // Handle error when inserting barang to stok
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i>
                            Gagal menambahkan barang ke stok: <?= mysqli_error($koneksi) ?>
                        </div>
        <?php
                    }
                }
            }
        }

        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="id_supplier">Supplier</label>
                    <?php
                    $selectSQL = "SELECT * FROM supplier ORDER BY id_supplier";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    ?>
                    <select class="form-select" name="id_supplier" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowSupplier = mysqli_fetch_assoc($resultSet)) {
                        ?>
                            <option value="<?= $rowSupplier['id_supplier'] ?>"><?= $rowSupplier["nama_supplier"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_pegawai">Penerima</label>
                    <?php
                    $selectSQL = "SELECT * FROM pegawai ORDER BY id_pegawai";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    ?>
                    <select class="form-select" name="id_pegawai" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowPegawai = mysqli_fetch_assoc($resultSet)) {
                        ?>
                            <option value="<?= $rowPegawai['id_pegawai'] ?>"><?= $rowPegawai["nama_pegawai"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nomor_masuk">Nomor Masuk</label>
                    <input type="text" class="form-control" name="nomor_masuk" value="<?= $nomorMasukBaru ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" required>
                </div>
                <div class="mb-3">
                    <label for="id_barang">Barang</label>
                    <?php
                    $selectSQL = "SELECT * FROM barang ORDER BY id_barang";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    ?>
                    <select class="form-select" name="id_barang" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowBarang = mysqli_fetch_assoc($resultSet)) {
                        ?>
                            <option value="<?= $rowBarang['id_barang'] ?>"><?= $rowBarang["kode_barang"] ?> - <?= $rowBarang["nama_barang"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="jumlah">Jumlah</label>
                        <div class="input-group">
                            <input type="number" id="jumlah" name="jumlah" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="harga_satuan">Harga Satuan</label>
                    <input type="text" id="harga_satuan" class="form-control" name="harga_satuan" required>
                </div>
                <div class="mb-3">
                    <label for="total">Total</label>
                    <input type="text" id="total" class="form-control" name="total" readonly required>
                </div>
                <div class="mb-3">
                    <label for="kondisi">Kondisi</label>
                    <select class="form-select" name="kondisi" required>
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="BAIK">BAIK</option>
                        <option value="RUSAK">RUSAK</option>
                    </select>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-success" type="submit" name="simpan_button">
                        <i class="fas fa-save"></i>
                        Tambah Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Fungsi untuk menghitung total secara otomatis
    function hitungTotal() {
        var jumlah = document.getElementById("jumlah").value;
        var hargaSatuan = document.getElementById("harga_satuan").value;
        var total = (jumlah * hargaSatuan);
        document.getElementById("total").value = total;
    }

    // Memanggil fungsi hitungTotal saat nilai jumlah atau harga_satuan berubah
    document.getElementById("jumlah").addEventListener("input", hitungTotal);
    document.getElementById("harga_satuan").addEventListener("input", hitungTotal);
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>