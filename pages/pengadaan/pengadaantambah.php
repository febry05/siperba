<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Data Pengadaan Barang</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=pengadaanbarang" class="btn btn-primary btn-sm float-end">
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
            $tgl_surat = $_POST['tgl_surat'];
            $no_surat = $_POST['no_surat'];
            $nama_barang = $_POST['barang'];
            $jenis = $_POST['jenis'];
            $jumlah = $_POST['jumlah'];
            $supplier = $_POST['supplier'];
            $pegawai = $_POST['pegawai'];
         

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
    
                $insertSQL = "INSERT INTO pengadaan SET tanggal_surat='$tgl_surat', nomor_surat='$no_surat',
                id_barang='$nama_barang',
                id_jenis='$jenis',
                jumlah='$jumlah',
                id_supplier='$supplier',
                id_pegawai='$pegawai',
                file='$filename',
                status='1'";
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
        <div class="card px-3 py-3">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="tgl_surat">Tanggal Surat </label>
                    <input type="date" class="form-control" name="tgl_surat">
                </div>
                <div class="mb-3">
                    <label for="no_surat">Nomor Surat </label>
                    <input type="text" class="form-control" name="no_surat">
                </div>

                <div class=" mb-3">
                    <label for="barang">Nama barang</label>
                    <?php
                    $selectJenisSQL = "SELECT * FROM barang ORDER BY id_barang";
                    $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                    ?>
                    <select class="form-select" name="barang" required>
                        <option value="">-- Pilih barang --</option>
                        <?php
                        while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                        ?>
                        <option value="<?= $rowJenis['id_barang'] ?>"><?= $rowJenis["nama_barang"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class=" mb-3">
                    <label for="jenis">Jenis</label>
                    <?php
                    $selectJenisSQL = "SELECT * FROM jenis ORDER BY id_jenis";
                    $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                    ?>
                    <select class="form-select" name="jenis" required>
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
                    <label for="jumlah">Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" required>
                </div>
                <div class=" mb-3">
                    <label for="supplier">Supplier</label>
                    <?php
                    $selectJenisSQL = "SELECT * FROM supplier ORDER BY id_supplier";
                    $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                    ?>
                    <select class="form-select" name="supplier" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php
                        while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                        ?>
                        <option value="<?= $rowJenis['id_supplier'] ?>"><?= $rowJenis["nama_supplier"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class=" mb-3">
                    <label for="pegawai">Kepala </label>
                    <?php
                    $selectJenisSQL = "SELECT * FROM pegawai ORDER BY id_pegawai";
                    $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                    ?>
                    <select class="form-select" name="pegawai" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php
                        while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                        ?>
                        <option value="<?= $rowJenis['id_pegawai'] ?>"><?= $rowJenis["nama_pegawai"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="file">Upload Surat </label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
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