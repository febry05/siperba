<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Data Master Supplier</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=suppliertambah" class="btn btn-success float-end">
                    <i class="fa fa-plus-circle"></i> Tambah
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
    $resultSet = mysqli_query($koneksi, "SELECT * FROM supplier");
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <table class="table bg-white rounded shadow-sm  table-hover" id="example">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>Supplier</th>
                        <th>Kontak</th>
                        <th>HP</th>
                        <th>Alamat</th>
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
                            <td><?= $row['nama_supplier'] ?></td>
                            <td><?= $row['nama_kontak'] ?></td>
                            <td><?= $row['nomor_hp'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td>
                                <a href="?page=supplierubah&id_supplier=<?= $row['id_supplier'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="?page=supplierhapus&id_supplier=<?= $row['id_supplier'] ?>" onclick="javascript: return confirm('Yakin hapus?');" class="btn btn-sm btn-danger">
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