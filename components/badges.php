<?php
function hitungQty($koneksi, $nama_tabel)
{
    $select = "SELECT COUNT(*) qty FROM $nama_tabel";
    $result = mysqli_query($koneksi, $select);
    $row = mysqli_fetch_assoc($result);
    return $row['qty'];
}


$divisi_qty = hitungQty($koneksi, "divisi");
$pegawai_qty = hitungQty($koneksi, "pegawai");
$supplier_qty = hitungQty($koneksi, "supplier");
$barang_qty = hitungQty($koneksi, "barang");


?>
<div id="badges" class="row g-3 my-2">
    <div class="col-md-6 col-lg-3">
        <div class="p-3 hijo-bg shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $divisi_qty ?></h3>
                <p class="fs-5 text-white">Divisi</p>
            </div>
            <i class="fas fa-building fs-1 text-white hijo-bg p-3"></i>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="p-3 bg-primary shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $supplier_qty ?></h3>
                <p class="fs-5 text-white">Supplier</p>
            </div>
            <i class="fas fa-money-bill fs-1 text-white bg-primary p-3"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="p-3 bg-danger shadow-sm d-flex justify-content-around align-items-center rounded">
            <div>
                <h3 class="fs-2"><?= $barang_qty ?></h3>
                <p class="fs-5 text-white">Barang</p>
            </div>
            <i class="fas fa-chart-line fs-1 text-white bg-danger p-3"></i>
        </div>
    </div>
</div>