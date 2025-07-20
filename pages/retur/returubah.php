<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data Master Barang</h3>
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
            $id_barang = $_POST['id_barang'];
            $kode_barang = $_POST['kode_barang'];
            $id_jenis = $_POST['id_jenis'];
            $nama_barang = $_POST['nama_barang'];
            $satuan = $_POST['satuan'];
            $checkSQL = "SELECT * FROM barang WHERE kode_barang = '$kode_barang' AND id_barang!=$id_barang";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0);
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Nama Barang sama sudah ada
                </div>
                <?php
            } else {
                $updateSQL = "UPDATE barang SET kode_barang='$kode_barang',
                id_jenis='$id_jenis',
                nama_barang='$nama_barang', 
                satuan='$satuan'
                WHERE id_barang=$id_barang";
                $result = mysqli_query($koneksi, $updateSQL);
                if (!$result) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Gagal memperbarui data: <?= mysqli_error($koneksi) ?>
                    </div>
                <?php
                    die(); // Menghentikan eksekusi kode selanjutnya
                } else {
                ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle"></i>
                        Data berhasil diubah
                    </div>
        <?php
                }
            }
        }

        $id_barang = $_GET['id_barang'];
        $selectSQL = "SELECT * FROM barang WHERE id_barang=$id_barang";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=barangdata'>";
        } else {
            $row = mysqli_fetch_assoc($result);
        }
        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="id_barang">ID</label>
                    <input type="text" class="form-control" name="id_barang" value="<?= $row['id_barang'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="id">Kode Barang</label>
                    <input type="text" class="form-control" name="kode_barang" value="<?= $row['kode_barang'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="id_jenis">Jenis</label>
                    <?php
                    $selectSQL = "SELECT * FROM jenis ORDER BY id_jenis";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    $default_tahun = 0;
                    ?>
                    <select class="form-select" name="id_jenis" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowjenis = mysqli_fetch_assoc($resultSet)) {
                            $selected = ($row['id_jenis'] == $rowjenis['id_jenis']) ? 'selected' : '';
                        ?>
                            <option value="<?= $rowjenis['id_jenis'] ?>" <?= $selected ?>><?= $rowjenis["jenis_barang"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" name="nama_barang" value="<?= $row['nama_barang'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="satuan">Satuan</label>
                    <input type="text" class="form-control" name="satuan" value="<?= $row['satuan'] ?>" required>
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