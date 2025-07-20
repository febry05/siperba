<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Data Master Pegawai</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=pegawaitambah" class="btn btn-success float-end">
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
    $selectSQL = "SELECT * FROM pegawai LEFT JOIN divisi ON pegawai.id_divisi = divisi.id_divisi";
    $resultSet = mysqli_query($koneksi, $selectSQL);
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <div class="table-responsive">
                <table class="table bg-white rounded shadow-sm  table-hover" id="example">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>Nama Pegawai</th>
                            <th>NIP</th>
                            <th>Divisi</th>
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
                                <td><?= $row['nama_pegawai'] ?></td>
                                <td><?= $row['nip'] ?></td>
                                <td><?= $row['nama_divisi'] ?></td>
                                <td>
                                    <a href="?page=pegawaiubah&id_pegawai=<?= $row['id_pegawai'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="?page=pegawaihapus&id_pegawai=<?= $row['id_pegawai'] ?>" onclick="javascript: return confirm('Yakin hapus?');" class="btn btn-sm btn-danger">
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