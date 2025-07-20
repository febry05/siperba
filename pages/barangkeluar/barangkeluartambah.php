<?php
$tahunSaatIni = date('Y');

$selectMaxNomorSQL = "SELECT MAX(RIGHT(nomor_keluar, 4)) AS max_nomor FROM barang_keluar WHERE LEFT(nomor_keluar, 4) = 'BK-$tahunSaatIni'";
$resultMaxNomor = mysqli_query($koneksi, $selectMaxNomorSQL);
$rowMaxNomor = mysqli_fetch_assoc($resultMaxNomor);
$maxNomor = $rowMaxNomor['max_nomor'];

$urutan = $maxNomor + 1;

while (true) {
    $nomorKeluarBaru = "BK-$tahunSaatIni-" . sprintf('%04d', $urutan);

    $checkExistenceSQL = "SELECT COUNT(*) AS jumlah FROM barang_keluar WHERE nomor_keluar = '$nomorKeluarBaru'";
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
                <h3>Tambah Data Barang Keluar</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=permintaandata" class="btn btn-primary btn-sm float-end">
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
            $nomor_keluar = $nomorKeluarBaru;
            $id_permintaan_detail = $_POST['id_permintaan_detail'];
            $tanggal_keluar = $_POST['tanggal_keluar'];
            $kondisi = $_POST['kondisi'];
            $jumlah = $_POST['jumlah'];

            $id_permintaan_detail = $_POST['id_permintaan_detail'];

            // Ubah query SQL untuk mengambil id_barang dari permintaan_detail
            $sql_id_barang = "SELECT id_barang FROM permintaan_detail WHERE id_permintaan_detail = $id_permintaan_detail";
            $result_id_barang = mysqli_query($koneksi, $sql_id_barang);

            if ($result_id_barang) {
                $row_id_barang = mysqli_fetch_assoc($result_id_barang);
                $id_barang = $row_id_barang['id_barang'];
            }
            // Mengambil jumlah stok barang
            $sql_stok_barang = "SELECT stok FROM stok WHERE id_barang = $id_barang";
            $result_stok_barang = mysqli_query($koneksi, $sql_stok_barang);

            if ($result_stok_barang) {
                $row_stok_barang = mysqli_fetch_assoc($result_stok_barang);
                $stok_barang = $row_stok_barang['stok'];

                // Memeriksa apakah stok mencukupi
                if ($stok_barang <= 0) {
                    // Jika stok habis, tampilkan pesan
        ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Stok barang habis. Tidak dapat menambahkan barang ke barang keluar.
                    </div>
                <?php
                } elseif ($stok_barang < $jumlah) {
                    // Jika stok tidak mencukupi, tampilkan pesan
                ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Stok barang tidak mencukupi untuk pengeluaran. Stok saat ini: <?= $stok_barang ?>.
                    </div>
                    <?php
                } else {
                    // Jika stok mencukupi, lanjutkan dengan penambahan data barang keluar

                    $updateStokSQL = "UPDATE stok SET stok = stok - $jumlah WHERE id_barang = $id_barang";
                    $resultStok = mysqli_query($koneksi, $updateStokSQL);

                    if (!$resultStok) {
                        // Gagal memperbarui stok barang
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i>
                            <?= mysqli_error($koneksi) ?>
                        </div>
                        <?php
                    } else {
                        // Berhasil memperbarui stok barang, lanjutkan dengan menambahkan data barang keluar
                        $insertSQL = "INSERT INTO barang_keluar SET nomor_keluar='$nomor_keluar', 
                id_permintaan_detail='$id_permintaan_detail',
                tanggal_keluar='$tanggal_keluar',
                kondisi='$kondisi'";
                        $resultInsert = mysqli_query($koneksi, $insertSQL);

                        if (!$resultInsert) {
                            // Gagal menambahkan data barang keluar
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fa fa-exclamation-circle"></i>
                                <?= mysqli_error($koneksi) ?>
                            </div>
                        <?php
                        } else {
                            // Berhasil menambahkan data barang keluar
                        ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fa fa-check-circle"></i>
                                Data berhasil ditambahkan
                            </div>
                            <?php

                            $updateDetailStatusSQL = "UPDATE permintaan_detail SET status = '3' WHERE id_permintaan_detail = $id_permintaan_detail";
                            $resultUpdateDetailStatus = mysqli_query($koneksi, $updateDetailStatusSQL);

                            if (!$resultUpdateDetailStatus) {
                                // Jika gagal menandai data sebagai terhapus
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fa fa-exclamation-circle"></i>
                                    Gagal menandai data sebagai terhapus: <?= mysqli_error($koneksi) ?>
                                </div>
        <?php
                            }
                        }
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
                <input type="hidden" name="id_permintaan_detail" value="<?= $_GET['id_permintaan_detail'] ?>">
                <div class="mb-3">
                    <label for="nomor_keluar">Nomor Keluar</label>
                    <input type="text" class="form-control" name="nomor_keluar" value="<?= $nomorKeluarBaru ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="tanggal_keluar">Tanggal Keluar</label>
                    <input type="date" class="form-control" name="tanggal_keluar" required>
                </div>
                <div class="mb-3">
                    <label for="nama_barang">Nama Barang</label>
                    <?php
                    $id_permintaan_detail = $_GET['id_permintaan_detail'];
                    $sql = "SELECT barang.nama_barang 
                    FROM permintaan_detail 
                    LEFT JOIN barang ON permintaan_detail.id_barang = barang.id_barang 
                    WHERE permintaan_detail.id_permintaan_detail = $id_permintaan_detail";
                    $result = mysqli_query($koneksi, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <input type="text" class="form-control" name="nama_barang" value="<?= isset($row['nama_barang']) ? $row['nama_barang'] : '' ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah">Jumlah</label>
                    <?php
                    $id_permintaan_detail = $_GET['id_permintaan_detail'];
                    $sql = "SELECT jumlah FROM permintaan_detail WHERE id_permintaan_detail = $id_permintaan_detail";
                    $result = mysqli_query($koneksi, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <input type="text" class="form-control" name="jumlah" value="<?= isset($row['jumlah']) ? $row['jumlah'] : '' ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_pegawai">Pegawai</label>
                    <?php
                    $id_permintaan_detail = $_GET['id_permintaan_detail'];
                    $sql = "SELECT pegawai.nama_pegawai 
                    FROM permintaan_detail 
                    LEFT JOIN permintaan ON permintaan_detail.id_permintaan = permintaan.id_permintaan
                    LEFT JOIN pegawai ON permintaan.id_pegawai = pegawai.id_pegawai 
                    WHERE permintaan_detail.id_permintaan_detail = $id_permintaan_detail";
                    $result = mysqli_query($koneksi, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <input type="text" class="form-control" name="nama_pegawai" value="<?= isset($row['nama_pegawai']) ? $row['nama_pegawai'] : '' ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_divisi">Divisi</label>
                    <?php
                    $id_permintaan_detail = $_GET['id_permintaan_detail'];
                    $sql = "SELECT divisi.nama_divisi 
                    FROM permintaan_detail 
                    LEFT JOIN permintaan ON permintaan_detail.id_permintaan = permintaan.id_permintaan
                    LEFT JOIN divisi ON permintaan.id_divisi = divisi.id_divisi 
                    WHERE permintaan_detail.id_permintaan_detail = $id_permintaan_detail";
                    $result = mysqli_query($koneksi, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <input type="text" class="form-control" name="nama_divisi" value="<?= isset($row['nama_divisi']) ? $row['nama_divisi'] : '' ?>" readonly>
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
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>