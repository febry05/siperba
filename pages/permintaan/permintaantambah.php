<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Data Permintaan</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=permintaandata" class="btn btn-primary float-end">
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
            $tgl_permintaan = $_POST['tgl_permintaan'];
            $id_pegawai = $_POST['id_pegawai'];
            $id_divisi = $_POST['id_divisi'];
            $no_surat = $_POST['no_surat'];

            // upload file
            $targetDir = "uploads/"; // Folder tujuan upload
            $targetFile = $targetDir . basename($_FILES["file"]["name"]);
            $filename =   $_FILES["file"]["name"];
            $uploadOk = 1;

   
            // Cek apakah ada file yang diupload
            if ($_FILES["file"]["error"] == 0) {
                // Cek ukuran file (misalnya max 5MB)
                if ($_FILES["file"]["size"] > 5000000) {
                    echo "File terlalu besar.";
                    $uploadOk = 0;
                }
                // Cek ekstensi file yang diperbolehkan
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ["jpg", "png", "pdf", "docx"];
                if (!in_array($fileType, $allowedTypes)) {
                    echo "Hanya file PDF dan Docx yang diizinkan.";
                    $uploadOk = 0;
                }

                // Jika semua oke, lakukan upload
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                     
                    } else {
                        echo "Terjadi kesalahan saat mengupload file.";
                    }
                }
            } else {
                echo "Tidak ada file yang diupload atau terjadi error.";
            }
    
            $insertSQL = "INSERT INTO permintaan (tgl_permintaan, id_pegawai, id_divisi,file,no_surat) VALUES ('$tgl_permintaan',$id_pegawai, $id_divisi,'$filename',$no_surat)";

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
        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="card px-3 py-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id">Tanggal</label>
                            <input type="date" name="tgl_permintaan" class="form-control" required
                                value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>

                    <?php
                $selectSQLDivisi = "SELECT * FROM divisi";
                $resultSetDivisi = mysqli_query($koneksi, $selectSQLDivisi);
                ?>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_divisi">Divisi</label>
                            <select name="id_divisi" id="" class="form-control">
                                <option value="">-- Pilih --</option>
                                <?php
                                while ($rowDivisi = mysqli_fetch_assoc($resultSetDivisi)) {
                                ?>
                                <option value="<?= $rowDivisi["id_divisi"] ?>"><?= $rowDivisi["nama_divisi"] ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                    $selectSQLPegawai = "SELECT * FROM pegawai";
                    $resultSetPegawai = mysqli_query($koneksi, $selectSQLPegawai);
                    ?>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_pegawai">Pegawai </label>
                            <select name="id_pegawai" id="" class="form-control">
                                <option value="">-- Pilih --</option>
                                <?php
                                while ($rowPegawai = mysqli_fetch_assoc($resultSetPegawai)) {
                                ?>
                                <option value="<?= $rowPegawai["id_pegawai"] ?>"><?= $rowPegawai["nama_pegawai"] ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_surat">Nomor Surat </label>
                            <input type="text" name="no_surat" id="no_surat" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="file">Upload Surat </label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col mb-3 mt-4">
                    <button class="btn btn-success" type="submit" name="simpan_button">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </div>
    </div>
    </form>
</div>
</div>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>