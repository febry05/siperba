<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Hapus Data Barang Keluar</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangkeluarkdata.php" class="btn btn-primary btn-sm float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        $id_barang_keluar = $_GET['id_barang_keluar'];
        $deleteSQL = "DELETE FROM barang_keluar WHERE id_barang_keluar = $id_barang_keluar";
        $result = mysqli_query($koneksi, $deleteSQL);
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
                Data berhasil dihapus
            </div>
            <meta http-equiv='refresh' content='2;url=?page=barangkeluardata'>
        <?php
        } ?>
    </div>
</div>