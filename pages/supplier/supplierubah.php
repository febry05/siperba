<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data supplier</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=supplierdata" class="btn btn-primary float-end">
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
            $nama_supplier = $_POST['nama_supplier'];
            $nama_kontak = $_POST['nama_kontak'];
            $nomor_hp = $_POST['nomor_hp'];
            $alamat = $_POST['alamat'];
            $checkSQL = "SELECT * FROM supplier WHERE nama_supplier = '$nama_supplier' AND id_supplier!=$id_supplier";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0) ? true : false;
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Nama Supplier sama sudah ada
                </div>
                <?php
            } else {
                $updateSQL = "UPDATE supplier SET nama_supplier='$nama_supplier', 
                nama_kontak='$nama_kontak',
                nomor_hp='$nomor_hp',
                alamat='$alamat'
                WHERE id_supplier=$id_supplier";
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

        $id_supplier = $_GET['id_supplier'];
        $selectSQL = "SELECT * FROM supplier WHERE id_supplier=$id_supplier";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=supplierdata'>";
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
                    <label for="id_supplier">id_supplier</label>
                    <input type="text" class="form-control" name="id_supplier" value="<?= $row['id_supplier'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_supplier">Nama Supplier</label>
                    <input type="text" class="form-control" name="nama_supplier" value="<?= $row['nama_supplier'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nama_kontak">Nama Kontak</label>
                    <input type="text" class="form-control" name="nama_kontak" value="<?= $row['nama_kontak'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nomor_hp">HP</label>
                    <input type="text" class="form-control" name="nomor_hp" value="<?= $row['nomor_hp'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" value="<?= $row['alamat'] ?>" required>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-success" type="submit" name="simpan_button">
                        <i class="fas fa-save"></i>
                        Ubah
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