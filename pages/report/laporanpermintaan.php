<div class="row mt-3">

    <div class="container mt-4 pb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Export Laporan Permintaan Barang</div>
            <div class="card-body">
                <form action="pages/report/exportpermintaanbarang.php" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status Permintaan</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Menunggu">Menunggu Persetujuan</option>
                                <option value="Ditolak">Tidak Disetujui</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-4 pb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Export Laporan Pengadaan Barang</div>
            <div class="card-body">
                <form action="pages/report/exportpengadaanbarang.php" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status Pengadaan</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Menunggu">Menunggu Persetujuan</option>
                                <option value="Ditolak">Tidak Disetujui</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-4 pb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Export Laporan Stok Barang</div>
            <div class="card-body">
                <form action="pages/report/exportstok.php" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="status" class="form-label">Jenis Barang</label>

                            <?php
                                $selectJenisSQL = "SELECT * FROM jenis ORDER BY id_jenis";
                                $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                                ?>
                            <select class="form-select" name="jenis">
                                <option value="">-- Semua Jenis --</option>
                                <?php
                                    while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                                    ?>
                                <option value="<?= $rowJenis['id_jenis'] ?>"><?= $rowJenis["jenis_barang"] ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>

                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4 pb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Export Laporan Rekap Barang</div>
            <div class="card-body">
                <form action="pages/report/exportrekap.php" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Jenis Barang</label>

                            <?php
                                $selectJenisSQL = "SELECT * FROM jenis ORDER BY id_jenis";
                                $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                                ?>
                            <select class="form-select" name="jenis">
                                <option value="">-- Semua Jenis --</option>
                                <?php
                                    while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                                    ?>
                                <option value="<?= $rowJenis['id_jenis'] ?>"><?= $rowJenis["jenis_barang"] ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>

                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4 pb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Export Laporan Barang Masuk</div>
            <div class="card-body">
                <form action="pages/report/exportbarangmasuk.php" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Suplier</label>
                            <?php
                                $selectJenisSQL = "SELECT * FROM supplier ORDER BY id_supplier ASC";
                                $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                                ?>
                            <select class="form-select" name="supplier">
                                <option value="">-- Semua Supplier --</option>
                                <?php
                                    while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                                    ?>
                                <option value="<?= $rowJenis['id_supplier'] ?>"><?= $rowJenis["nama_supplier"] ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>

                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4 pb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">Export Laporan Barang Keluar</div>
            <div class="card-body">
                <form action="pages/report/exportbarangkeluar.php" method="get" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Suplier</label>
                            <?php
                                $selectJenisSQL = "SELECT * FROM divisi ORDER BY id_divisi ASC";
                                $resultSetJenis = mysqli_query($koneksi, $selectJenisSQL);
                                ?>
                            <select class="form-select" name="divisi">
                                <option value="">-- Semua Supplier --</option>
                                <?php
                                    while ($rowJenis = mysqli_fetch_assoc($resultSetJenis)) {
                                    ?>
                                <option value="<?= $rowJenis['id_divisi'] ?>"><?= $rowJenis["nama_divisi"] ?>
                                </option>
                                <?php
                                    }
                                    ?>
                            </select>

                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">Export PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>