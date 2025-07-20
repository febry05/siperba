<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Data User</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=usertambah" class="btn btn-success float-end">
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
    $resultSet = mysqli_query($koneksi, "SELECT * FROM user");
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm  table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Nama Pegawai</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th width="200">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($resultSet)) {
                        ?>
                            <tr class="align-middle">
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['nama_pegawai'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['level'] ?></td>
                                <td>
                                    <a href="?page=userubah&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="?page=userhapus&id=<?= $row['id'] ?>" onclick="javascript: return confirm('Yakin hapus?');" class="btn btn-sm btn-danger">
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