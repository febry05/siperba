<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data Pegawai</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=pegawaidata" class="btn btn-primary float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        $id_pegawai = $_GET['id_pegawai'];
        if (isset($_POST['simpan_button'])) {
            $nama_pegawai = $_POST['nama_pegawai'];
            $nip = $_POST['nip'];
            $id_divisi = $_POST['id_divisi'];
            $checkSQL = "SELECT * FROM pegawai WHERE nama_pegawai = '$nama_pegawai' AND id_pegawai!=$id_pegawai";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0) ? true : false;
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Nama Pegawai Sudah Ada
                </div>
                <?php
            } else {
                $updateSQL = "UPDATE pegawai SET nama_pegawai='$nama_pegawai', 
                    nip='$nip',
                    id_divisi='$id_divisi'
                    WHERE id_pegawai=$id_pegawai";
                $result = mysqli_query($koneksi, $updateSQL);
                if (!$result) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        <?= mysqli_error($koneksi) ?>
                        <?= $updateSQL ?>
                    </div>
                <?php
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

        $selectSQL = "SELECT * FROM pegawai WHERE id_pegawai=$id_pegawai";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=pegawaidata'>";
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
                    <label for="nama_pegawai">Nama Pegawai</label>
                    <input type="text" class="form-control" name="nama_pegawai" value="<?= isset($row['nama_pegawai']) ? $row['nama_pegawai'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" name="nip" value="<?= isset($row['nip']) ? $row['nip'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="id_divisi">Divisi</label>
                    <?php
                    $selectDivisiSQL = "SELECT * FROM divisi ORDER BY id_divisi";
                    $resultSetDivisi = mysqli_query($koneksi, $selectDivisiSQL);
                    ?>
                    <select class="form-select" name="id_divisi" required>
                        <option value="">-- Pilih Divisi --</option>
                        <?php
                        while ($rowDivisi = mysqli_fetch_assoc($resultSetDivisi)) {
                            $selected = ($rowDivisi['id_divisi'] == $row['id_divisi']) ? 'selected' : '';
                        ?>
                            <option value="<?= $rowDivisi['id_divisi'] ?>" <?= $selected ?>><?= $rowDivisi["nama_divisi"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
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