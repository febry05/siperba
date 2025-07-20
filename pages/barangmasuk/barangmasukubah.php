<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data Barang Masuk</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangmasukdata" class="btn btn-primary btn-sm float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        $id_barang_masuk = $_GET['id_barang_masuk'];
        if (isset($_POST['simpan_button'])) {
            $id_supplier = $_POST['id_supplier'];
            $id_pegawai = $_POST['id_pegawai'];
            $nomor_masuk = $_POST['nomor_masuk'];
            $tanggal_masuk = $_POST['tanggal_masuk'];
            $id_barang = $_POST['id_barang'];
            $jumlah = $_POST['jumlah'];
            $harga_satuan = $_POST['harga_satuan'];
            $total = $_POST['total'];
            $kondisi = $_POST['kondisi'];

            // Memperbarui jumlah stok di tabel stok
            $updateStokSQL = "UPDATE stok SET stok = stok - (SELECT jumlah FROM barang_masuk WHERE id_barang_masuk = $id_barang_masuk) + $jumlah WHERE id_barang = $id_barang";;
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
                // Berhasil memperbarui stok barang, lanjutkan dengan menambahkan data barang masuk
                $updateSQL = "UPDATE barang_masuk SET id_supplier='$id_supplier',
                id_pegawai='$id_pegawai',
                nomor_masuk='$nomor_masuk',
                id_barang='$id_barang',
                tanggal_masuk='$tanggal_masuk',
                jumlah='$jumlah',
                harga_satuan='$harga_satuan',
                total='$total',
                kondisi='$kondisi'
                WHERE id_barang_masuk=$id_barang_masuk";
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

        $selectSQL = "SELECT * FROM barang_masuk WHERE id_barang_masuk=$id_barang_masuk";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=bmdetaildata'>";
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
                    <label for="id_supplier">Supplier</label>
                    <?php
                    $selectSQL = "SELECT * FROM supplier ORDER BY id_supplier";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    ?>
                    <select class="form-select" name="id_supplier" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowSupplier = mysqli_fetch_assoc($resultSet)) {
                            $selected = ($row['id_supplier'] == $rowSupplier['id_supplier']) ? 'selected' : '';
                        ?>
                            <option value="<?= $rowSupplier['id_supplier'] ?>" <?= $selected ?>><?= $rowSupplier["nama_supplier"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_pegawai">Penerima</label>
                    <?php
                    $selectSQL = "SELECT * FROM pegawai ORDER BY id_pegawai";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    ?>
                    <select class="form-select" name="id_pegawai" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowPegawai = mysqli_fetch_assoc($resultSet)) {
                            $selected = ($row['id_pegawai'] == $rowPegawai['id_pegawai']) ? 'selected' : '';
                        ?>
                            <option value="<?= $rowPegawai['id_pegawai'] ?>" <?= $selected ?>><?= $rowPegawai["nama_pegawai"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nomor_masuk">Nomor Masuk</label>
                    <input type="text" class="form-control" name="nomor_masuk" value="<?= isset($row['nomor_masuk']) ? $row['nomor_masuk'] : '' ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" value="<?= isset($row['tanggal_masuk']) ? $row['tanggal_masuk'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="id_barang">Barang</label>
                    <?php
                    $selectSQL = "SELECT * FROM barang ORDER BY id_barang";
                    $resultSet = mysqli_query($koneksi, $selectSQL);
                    $default_tahun = 0;
                    ?>
                    <select class="form-select" name="id_barang" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowBarang = mysqli_fetch_assoc($resultSet)) {
                            $selected = ($row['id_barang'] == $rowBarang['id_barang']) ? 'selected' : '';
                        ?>
                            <option value="<?= $rowBarang['id_barang'] ?>" <?= $selected ?>><?= $rowBarang["kode_barang"] ?> - <?= $rowBarang["nama_barang"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="jumlah">Jumlah</label>
                        <div class="input-group">
                            <input type="number" id="jumlah" name="jumlah" class="form-control" value="<?= isset($row['jumlah']) ? $row['jumlah'] : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="harga_satuan">Harga Satuan</label>
                    <input type="text" id="harga_satuan" class="form-control" name="harga_satuan" value="<?= isset($row['harga_satuan']) ? $row['harga_satuan'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="total">Total</label>
                    <input type="text" id="total" class="form-control" name="total" value="<?= isset($row['total']) ? $row['total'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kondisi">Kondisi</label>
                    <select class="form-select" name="kondisi" required>
                        <option value="BAIK" <?= ($row['kondisi'] == 'BAIK') ? 'selected' : '' ?>>BAIK</option>
                        <option value="RUSAK" <?= ($row['kondisi'] == 'RUSAK') ? 'selected' : '' ?>>RUSAK</option>
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
    // Fungsi untuk menghitung total secara otomatis
    function hitungTotal() {
        var jumlah = document.getElementById("jumlah").value;
        var hargaSatuan = document.getElementById("harga_satuan").value;
        var total = (jumlah * hargaSatuan);
        document.getElementById("total").value = total;
    }

    // Memanggil fungsi hitungTotal saat nilai jumlah atau harga_satuan berubah
    document.getElementById("jumlah").addEventListener("input", hitungTotal);
    document.getElementById("harga_satuan").addEventListener("input", hitungTotal);
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>