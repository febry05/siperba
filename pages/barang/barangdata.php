<div id="atas" class="row">
    <div class="col">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>Data Master Barang</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end gap-2">
                <a href="?page=barangtambah" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i> Tambah
                </a>
                <a href="pages/report/exportbarang.php" target="_blank" class="btn btn-warning">
                    Export PDF
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <script>
    // konfirmasi()
    // pesanToast()
    </script>
    <?php
    // Lakukan JOIN antara tabel barang dan jenis
    $query = "SELECT barang.*, jenis.jenis_barang FROM barang JOIN jenis ON barang.id_jenis = jenis.id_jenis";
    $resultSet = mysqli_query($koneksi, $query);
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>Kode Barang</th>
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th width="200">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($resultSet)) {
                        ?>
                        <tr class="align-middle">
                            <td><?= $no++ ?></td>
                            <td><?= $row['kode_barang'] ?></td>
                            <td><?= $row['jenis_barang'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['satuan'] ?></td>
                            <td>
                                <a href="?page=barangubah&id_barang=<?= $row['id_barang'] ?>"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#"
                                    onclick="konfirmasi('?page=baranghapus&id_barang=<?= $row['id_barang'] ?>');"
                                    class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
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