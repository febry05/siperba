<?php

// Periksa apakah id_permintaan sudah diterima dari parameter GET
if (isset($_GET['id_permintaan'])) {
    $id_permintaan = $_GET['id_permintaan'];

    // Query untuk mendapatkan data permintaan berdasarkan id_permintaan
    $query = "SELECT permintaan.*, pegawai.nama_pegawai, divisi.nama_divisi
              FROM permintaan
              JOIN pegawai ON permintaan.id_pegawai = pegawai.id_pegawai
              JOIN divisi ON pegawai.id_divisi = divisi.id_divisi
              WHERE permintaan.id_permintaan = $id_permintaan";

    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['tambah_barang'])) {
        $id_barang = $_POST['id_barang'];
        $jumlah = $_POST['jumlah'];

        // Query untuk menambahkan barang pada permintaan_detail
        $insertBarangSQL = "INSERT INTO permintaan_detail (id_permintaan, id_barang, jumlah, status) 
                            VALUES ($id_permintaan, $id_barang, $jumlah, 0)";

        $resultInsertBarang = mysqli_query($koneksi, $insertBarangSQL);

        if (!$resultInsertBarang) {
?>
<div class="alert alert-danger" role="alert">
    <i class="fa fa-exclamation-circle"></i>
    Gagal menambahkan barang: <?= mysqli_error($koneksi) ?>
</div>
<?php
        } else {
        ?>
<div class="alert alert-success" role="alert">
    <i class="fa fa-check-circle"></i>
    Barang berhasil ditambahkan
</div>
<?php
        }
    }

    ?>
<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Detail Permintaan Barang</h3>
            </div>
            <div class="col-md-6">
                <!-- Tombol untuk kembali ke halaman permintaandata.php -->
                <a href="?page=permintaandata" class="btn btn-primary float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="card my-card">
        <div class="row px-3 py-3">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="tgl_permintaan">Tanggal Permintaan</label>
                    <input type="text" class="form-control" value="<?= $row['tgl_permintaan'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="nama_pegawai">Nama</label>
                    <input type="text" class="form-control" value="<?= $row['nama_pegawai'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="nama_divisi">Divisi</label>
                    <input type="text" class="form-control" value="<?= $row['nama_divisi'] ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="bawah_detail" class="row mt-3">

    <div class="col">
        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Pegawai") : ?>
        <div class="card px-3 py-3">

            <!-- Form tambah barang -->
            <form action="" method="post">
                <div class="row px-3 py-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="id_barang">Pilih Barang</label>
                            <!-- Tambahkan dropdown untuk memilih barang -->
                            <select name="id_barang" class="form-control" required>
                                <?php
                                        // Query untuk mendapatkan daftar barang
                                        $queryBarang = "SELECT * FROM barang";
                                        $resultBarang = mysqli_query($koneksi, $queryBarang);

                                        while ($rowBarang = mysqli_fetch_assoc($resultBarang)) {
                                        ?>
                                <option value="<?= $rowBarang['id_barang'] ?>"><?= $rowBarang['nama_barang'] ?></option>
                                <?php
                                        }
                                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="mb-3">
                            <button type="submit" name="tambah_barang" class="btn btn-success">
                                <i class="fa fa-plus"></i> Tambah Barang
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>

</div>

<div id="bawah" class="row mt-3">
    <div class="col">

        <div class="card my-card mt-3">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Opsi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Tambahkan kode di bawah ini
                            if (isset($_POST['action']) && isset($_POST['id_barang'])) {
                                $action = $_POST['action'];
                                $id_barang = $_POST['id_barang'];

                                // Update status berdasarkan aksi
                                if ($action == 'setujui') {
                                    $updateStatusSQL = "UPDATE permintaan_detail SET status = '1' WHERE id_permintaan = $id_permintaan AND id_barang = $id_barang";
                                } elseif ($action == 'tidak_setujui') {
                                    $updateStatusSQL = "UPDATE permintaan_detail SET status = '2' WHERE id_permintaan = $id_permintaan AND id_barang = $id_barang";
                                }

                                $resultUpdateStatus = mysqli_query($koneksi, $updateStatusSQL);

                                if (!$resultUpdateStatus) {
                                    die("Query error: " . mysqli_error($koneksi));
                                }
                            }
                            ?>
                        <?php
                            // Query untuk mendapatkan detail barang permintaan berdasarkan id_permintaan
                            $queryDetail = "SELECT permintaan_detail.*, barang.kode_barang, barang.nama_barang, barang.satuan
                                            FROM permintaan_detail
                                            JOIN barang ON permintaan_detail.id_barang = barang.id_barang
                                            WHERE permintaan_detail.id_permintaan = $id_permintaan";

                            $resultDetail = mysqli_query($koneksi, $queryDetail);

                            if (!$resultDetail) {
                                die("Query error: " . mysqli_error($koneksi));
                            }

                            $no = 1;
                            while ($rowDetail = mysqli_fetch_assoc($resultDetail)) {
                            ?>
                        <tr class="align-middle">
                            <td><?= $no++ ?></td>
                            <td><?= $rowDetail['kode_barang'] ?></td>
                            <td><?= $rowDetail['nama_barang'] ?></td>
                            <td><?= $rowDetail['satuan'] ?></td>
                            <td><?= $rowDetail['jumlah'] ?></td>
                            <td>
                                <?php
                                        $status = $rowDetail['status'];

                                        if ($status == '0') {
                                            echo '<span class="text-warning">Menunggu Persetujuan</span>';
                                        } elseif ($status == '1') {
                                            echo '<span class="text-primary">Telah Disetujui</span>';
                                        } elseif ($status == '2') {
                                            echo '<span class="text-danger">Tidak Disetujui</span>';
                                        } elseif ($status == '3') {
                                            echo '<span class="text-success">Selesai</span>';
                                        } else {
                                            echo '<span class="text-secondary">Status Tidak Valid: ' . htmlspecialchars($status) . '</span>';
                                        }
                                        ?>
                            </td>

                            <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Kepala Bagian" && $rowDetail['status'] == '0') : ?>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="setujui">
                                    <input type="hidden" name="id_barang" value="<?= $rowDetail['id_barang'] ?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Setujui</button>
                                </form>
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="tidak_setujui">
                                    <input type="hidden" name="id_barang" value="<?= $rowDetail['id_barang'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Tidak Setuju</button>
                                </form>
                            </td>
                            <?php endif; ?>
                            <?php
                                    // Memindahkan pemrosesan aksi ke dalam loop while
                                    if (isset($_POST['action'])) {
                                        $action = $_POST['action'];
                                        $id_barang = $_POST['id_barang'];

                                        // Query untuk mengupdate status
                                        if ($action == 'setujui') {
                                            $updateStatusSQL = "UPDATE permintaan_detail SET status = '1' WHERE id_permintaan = $id_permintaan AND id_barang = $id_barang";
                                        } elseif ($action == 'tidak_setujui') {
                                            $updateStatusSQL = "UPDATE permintaan_detail SET status = '2' WHERE id_permintaan = $id_permintaan AND id_barang = $id_barang";
                                        }

                                        $resultUpdateStatus = mysqli_query($koneksi, $updateStatusSQL);

                                        if (!$resultUpdateStatus) {
                                            die("Query error: " . mysqli_error($koneksi));
                                        }
                                    }
                                    ?>
                            <td>
                                <?php if ($rowDetail['status'] == '0' && (isset($_SESSION["level"]) && $_SESSION["level"] == "Pegawai" || isset($_SESSION["level"]) && $_SESSION["level"] == "Admin")) : ?>
                                <a href="#" class="btn btn-warning"
                                    onclick="alert('Menunggu Persetujuan Kepala Bagian');">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                <?php elseif ($rowDetail['status'] == '1' && isset($_SESSION["level"]) && $_SESSION["level"] == "Admin") : ?>
                                <a href="?page=barangkeluartambah&id_permintaan_detail=<?= $rowDetail['id_permintaan_detail'] ?>"
                                    class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i>
                                </a>
                                <?php elseif ($rowDetail['status'] == '1') : ?>
                                <a href="" class="btn btn-primary"
                                    onclick="alert('Menunggu Admin Mengeluarkan Barang');">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                <?php elseif ($rowDetail['status'] == '2') : ?>
                                <a href="" class="btn btn-danger"
                                    onclick="alert('Permintaan Tidak Disetujui Kepala Bagian');">
                                    <i class="fa fa-close"></i>
                                </a>
                                <?php elseif ($rowDetail['status'] == '3') : ?>
                                <a href="" class="btn btn-success" onclick="alert('Barang Sudah Disiapkan');">
                                    <i class="fa fa-check"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                            }
                            ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<?php
} else {
    echo "Permintaan tidak ditemukan.";
}
?>