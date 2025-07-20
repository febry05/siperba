<?php
$tahunSaatIni = date('m.y');

$selectMaxNomorSQL = "SELECT MAX(RIGHT(kode_barang, 4)) AS max_nomor FROM barang WHERE LEFT(kode_barang, 4) = '11.$tahunSaatIni'";
$resultMaxNomor = mysqli_query($koneksi, $selectMaxNomorSQL);
$rowMaxNomor = mysqli_fetch_assoc($resultMaxNomor);
$maxNomor = $rowMaxNomor['max_nomor'];

$urutan = $maxNomor + 1;

while (true) {
    $nomorBarangBaru = "11.$tahunSaatIni." . sprintf('%04d', $urutan);

    $checkExistenceSQL = "SELECT COUNT(*) AS jumlah FROM barang WHERE kode_barang = '$nomorBarangBaru'";
    $resultExistence = mysqli_query($koneksi, $checkExistenceSQL);
    $rowExistence = mysqli_fetch_assoc($resultExistence);

    if ($rowExistence['jumlah'] == 0) {
        break;
    }

    $urutan++;
}
?>
<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Data Stok Barang</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangdata" class="btn btn-primary btn-sm float-end">
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
            $kode_barang = $nomorBarangBaru;
            $id_jenis = $_POST['id_jenis'];
            $nama_barang = $_POST['nama_barang'];
            $satuan = $_POST['satuan'];
            $checkSQL = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0) ? true : false;
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Nama Barang sama sudah ada
                </div>
                <?php
            } else {
                $insertSQL = "INSERT INTO barang SET kode_barang='$kode_barang', 
                id_jenis='$id_jenis',
                nama_barang='$nama_barang',
                satuan='$satuan'";
                $result = mysqli_query($koneksi, $insertSQL);
                if (!$result) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        <?= mysqli_error($koneksi) ?>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle"></i>
                        Data berhasil ditambahkan
                    </div>
        <?php
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
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" class="form-control" name="kode_barang" value="<?= $nomorBarangBaru ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="id_jenis">Jenis</label>
                    <?php
                    $selectJenisSQL = "SELECT * FROM jenis ORDER BY id_jenis";
                    $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                    ?>
                    <select class="form-select" name="id_jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php
                        while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                        ?>
                            <option value="<?= $rowJenis['id_jenis'] ?>"><?= $rowJenis["jenis_barang"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" name="nama_barang" required>
                </div>
                <div class="mb-3">
                    <label for="satuan">Satuan</label>
                    <input type="text" class="form-control" name="satuan" required>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-success" type="submit" name="simpan_button">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>