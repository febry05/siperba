<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data User</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=userdata" class="btn btn-primary float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        $id = $_GET['id'];
        if (isset($_POST['simpan_button'])) {
            $nama_pegawai = $_POST['nama_pegawai'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_ulangi = $_POST['password_ulangi'];
            $level = $_POST['level'];
            $checkSQL = "SELECT * FROM user WHERE username = '$username' AND id!=$id";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0) ? true : false;
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Username sama sudah ada
                </div>
                <?php
            } else {
                $passwordBeda = $password != $password_ulangi ? true : false;
                $updatePassword = $password == "" ? "" : ",password=MD5('$password')";
                if ($passwordBeda) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Password Beda
                    </div>
                    <?php
                } else {
                    $updateSQL = "UPDATE user SET nama_pegawai='$nama_pegawai', 
                    username='$username',
                    email='$email',
                    password=MD5('$password') $updatePassword, 
                    level='$level'
                    WHERE id=$id";
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
        }

        $selectSQL = "SELECT * FROM user WHERE id=$id";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=userdata'>";
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
                    <input type="text" class="form-control" name="nama_pegawai" value="<?= $row['nama_pegawai'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" value="<?= $row['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password_ulangi">
                </div>
                <div class="mb-3">
                    <label for="level">Level</label>
                    <select class="form-select" name="level" required>
                        <option value="Admin" <?= ($row['level'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="Kepala Bagian" <?= ($row['level'] == 'Kepala Bagian') ? 'selected' : '' ?>>Kepala Bagian</option>
                        <option value="Pegawai" <?= ($row['level'] == 'Pegawai') ? 'selected' : '' ?>>Pegawai</option>
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