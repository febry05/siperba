<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Profil</h3>
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
            $id_pegawai = isset($_POST['id_pegawai']) ? $_POST['id_pegawai'] : '';
            $nama_pegawai = isset($_POST['nama_pegawai']) ? $_POST['nama_pegawai'] : '';
            $nip = isset($_POST['nip']) ? $_POST['nip'] : '';
            $id_divisi = isset($_POST['id_divisi']) ? $_POST['id_divisi'] : '';

            // Gunakan prepared statement atau sanitasi input untuk mencegah SQL Injection
            $updateSQL = "UPDATE pegawai SET nama_pegawai=?, nip=?, id_divisi=? WHERE id_pegawai=?";
            $stmt = mysqli_prepare($koneksi, $updateSQL);

            // Periksa apakah prepared statement berhasil dibuat
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssi", $nama_pegawai, $nip, $id_divisi, $id_pegawai);
                $result = mysqli_stmt_execute($stmt);

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
            } else {
                // Jika prepared statement gagal dibuat, tampilkan pesan error
                ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    <?= "Gagal membuat prepared statement: " . mysqli_error($koneksi) ?>
                </div>
            <?php
            }
        }


        // Inisialisasi variabel $id_pegawai jika belum tersedia
        $id_pegawai = isset($_POST['id_pegawai']) ? $_POST['id_pegawai'] : '';

        // Query untuk mendapatkan data pegawai berdasarkan id_pegawai
        $selectSQL = "SELECT * FROM pegawai LEFT JOIN divisi ON pegawai.id_divisi = divisi.id_divisi";
        $result = mysqli_query($koneksi, $selectSQL);

        // Periksa apakah query berhasil dieksekusi sebelum menggunakan mysqli_fetch_assoc()
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            // Tampilkan pesan kesalahan jika query gagal dieksekusi
            ?>
            <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                <?= "Gagal mengambil data pegawai: " . mysqli_error($koneksi) ?>
            </div>
        <?php
        }
        ?>

    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                <div class="mb-3">
                    <label for="nama_pegawai">Nama pegawai</label>
                    <input type="text" class="form-control" name="nama_pegawai" value="<?= $row['nama_pegawai'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" name="nip" value="<?= $row['nip'] ?? '' ?>" required>
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