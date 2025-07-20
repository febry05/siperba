<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data Divisi</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=divisidata" class="btn btn-primary float-end">
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
            $id_divisi = $_POST['id_divisi'];
            $nama_divisi = $_POST['nama_divisi'];
            $checkSQL = "SELECT * FROM divisi WHERE nama_divisi = '$nama_divisi' AND id_divisi!=$id_divisi";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0) ? true : false;
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Nama Divisi sama sudah ada
                </div>
                <?php
            } else {
                $updateSQL = "UPDATE divisi SET nama_divisi='$nama_divisi' WHERE id_divisi=$id_divisi";
                $result = mysqli_query($koneksi, $updateSQL);
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
                        Data berhasil diubah
                    </div>
        <?php
                }
            }
        }

        $id_divisi = $_GET['id_divisi'];
        $selectSQL = "SELECT * FROM divisi WHERE id_divisi=$id_divisi";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=divisidata'>";
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
                    <label for="id_divisi">id_divisi</label>
                    <input type="text" class="form-control" name="id_divisi" value="<?= $row['id_divisi'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_divisi">Nama Divisi</label>
                    <input type="text" class="form-control" name="nama_divisi" value="<?= $row['nama_divisi'] ?>" required>
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