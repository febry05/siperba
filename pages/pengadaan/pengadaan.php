<div id="atas" class="row">
    <div class="col">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3>Data Pengadaan Barang</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end gap-2">
                <a href="?page=pengadaantambah" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i> Tambah
                </a>
                <!-- <a href="pages/report/exportbarang.php" target="_blank" class="btn btn-warning">
                    Export PDF
                </a> -->
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
    $query = "SELECT a.id_pengadaan,a.tanggal_surat,a.nomor_surat,b.nama_barang,j.jenis_barang,b.satuan,p.nama_pegawai,a.status,a.jumlah ,s.nama_supplier
                FROM `pengadaan` as a
                LEFT JOIN barang AS b ON b.id_barang = a.id_barang
                LEFT JOIN jenis AS j ON j.id_jenis = b.id_jenis
                LEFT JOIN pegawai AS p ON p.id_pegawai = a.id_pegawai
                LEFT JOIN supplier AS s ON s.id_supplier = a.id_supplier";
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
                            <th>Tanggal Surat</th>
                            <th>Nomor Surat</th>
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Supplier</th>
                            <th>Kepala</th>
                            <th>Status</th>
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
                            <td><?= $row['tanggal_surat'] ?></td>
                            <td><?= $row['nomor_surat'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['jenis_barang'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><?= $row['satuan'] ?></td>
                            <td><?= $row['nama_supplier'] ?></td>
                            <td><?= $row['nama_pegawai'] ?></td>
                            <td> <?php
                                        $status = $row['status'];

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
                                        ?></td>
                            <td>
                                <a href="?page=pengadaanubah&id_pengadaan=<?= $row['id_pengadaan'] ?>"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#"
                                    onclick="konfirmasi('?page=pengadaanhapus&id_barang=<?= $row['id_pengadaan']; ?>');"
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