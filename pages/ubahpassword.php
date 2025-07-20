<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Password</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=dashboard" class="btn btn-primary float-end">
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
            $id = $_POST['id'];
            $password_lama = $_POST['password_lama'];
            $password_baru = $_POST['password_baru'];
            $password_baru_ulangi = $_POST['password_baru_ulangi'];

            $select = "SELECT * FROM pegawai WHERE id=$id AND password=MD5('$password_lama')";
            $result = mysqli_query($koneksi, $select);
            $ada = (mysqli_num_rows($result) > 0) ? true : false;

            if ($ada) {
                if ($password_baru == $password_baru_ulangi) {
                    $updateSQL = "UPDATE pegawai SET password=MD5('$password_baru') 
                    WHERE id=$id";
                    $result = mysqli_query($koneksi, $updateSQL);
                    if (!$result) {
        ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i>
                            <?= mysqli_error($koneksi) ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle"></i>
                        Password berhasil diubah
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Password baru tidak sesuai
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Password lama tidak sesuai
                </div>
        <?php
            }
        }

        $id = $_SESSION['id'];
        $select = "SELECT * FROM pegawai WHERE id = $id";
        $result = mysqli_query($koneksi, $select);
        $row = mysqli_fetch_assoc($result);

        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col-md-5">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="mb-3">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" class="form-control" name="password_lama" required>
                </div>
                <div class="mb-3">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" class="form-control" name="password_baru" required>
                </div>
                <div class="mb-3">
                    <label for="password_baru_ulangi">Password Baru (Ulangi)</label>
                    <input type="password" class="form-control" name="password_baru_ulangi" required>
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