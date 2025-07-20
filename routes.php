<?php

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "";
}

switch ($page) {
    case "":
    case "dashboard":
        include "pages/dashboard.php";
        break;
    case "divisidata":
        include "pages/divisi/divisidata.php";
        break;
    case "divisitambah":
        include "pages/divisi/divisitambah.php";
        break;
    case "divisiubah":
        include "pages/divisi/divisiubah.php";
        break;
    case "divisihapus":
        include "pages/divisi/divisihapus.php";
        break;

    case "barangdata":
        include "pages/barang/barangdata.php";
        break;
    case "barangtambah":
        include "pages/barang/barangtambah.php";
        break;
    case "barangubah":
        include "pages/barang/barangubah.php";
        break;
    case "baranghapus":
        include "pages/barang/baranghapus.php";
        break;

    case "supplierdata":
        include "pages/supplier/supplierdata.php";
        break;
    case "suppliertambah":
        include "pages/supplier/suppliertambah.php";
        break;
    case "supplierubah":
        include "pages/supplier/supplierubah.php";
        break;
    case "supplierhapus":
        include "pages/supplier/supplierhapus.php";
        break;

    case "pegawaidata":
        include "pages/pegawai/pegawaidata.php";
        break;
    case "pegawaitambah":
        include "pages/pegawai/pegawaitambah.php";
        break;
    case "pegawaiubah":
        include "pages/pegawai/pegawaiubah.php";
        break;
    case "pegawaihapus":
        include "pages/pegawai/pegawaihapus.php";
        break;

    case "userdata":
        include "pages/user/userdata.php";
        break;
    case "usertambah":
        include "pages/user/usertambah.php";
        break;
    case "userubah":
        include "pages/user/userubah.php";
        break;
    case "userhapus":
        include "pages/user/userhapus.php";
        break;

    case "stokbarangdata":
        include "pages/stokbarang/stokbarangdata.php";
        break;
    case "stokbarangtambah":
        include "pages/stokbarang/stokbarangtambah.php";
        break;
    case "stokbarangubah":
        include "pages/stokbarang/stokbarangubah.php";
        break;
    case "stokbaranghapus":
        include "pages/stokbarang/stokbaranghapus.php";
        break;

    case "barangmasukdata":
        include "pages/barangmasuk/barangmasukdata.php";
        break;
    case "barangmasuktambah":
        include "pages/barangmasuk/barangmasuktambah.php";
        break;
    case "barangmasukubah":
        include "pages/barangmasuk/barangmasukubah.php";
        break;
    case "barangmasukhapus":
        include "pages/barangmasuk/barangmasukhapus.php";
        break;

    case "barangkeluardata":
        include "pages/barangkeluar/barangkeluardata.php";
        break;
    case "barangkeluartambah":
        include "pages/barangkeluar/barangkeluartambah.php";
        break;
    case "barangkeluarubah":
        include "pages/barangkeluar/barangkeluarubah.php";
        break;
    case "barangkeluarhapus":
        include "pages/barangkeluar/barangkeluarhapus.php";
        break;

    case "permintaandata":
        include "pages/permintaan/permintaandata.php";
        break;
    case "permintaantambah":
        include "pages/permintaan/permintaantambah.php";
        break;
    case "permintaanubah":
        include "pages/permintaan/permintaanubah.php";
        break;
    case "permintaanhapus":
        include "pages/permintaan/permintaanhapus.php";
        break;
    case "permintaandetail":
        include "pages/permintaan/permintaandetail.php";
        break;

    case "returdata":
        include "pages/retur/returdata.php";
        break;
    case "returtambah":
        include "pages/retur/returtambah.php";
        break;
    case "returdetail":
        include "pages/retur/returdetail.php";
        break;
    case "returubah":
        include "pages/retur/returubah.php";
        break;
    case "returhapus":
        include "pages/retur/returhapus.php";
        break;

    case "laporanstokbarang":
        include "report/laporanstokbarang.php";
        break;

    case "laporanbarangmasuk":
        include "report/res/laporanbarangmasuk.php";
        break;

    case "laporanbarangkeluar":
        include "report/res/laporanbarangkeluar.php";
        break;

    case "ubahprofil":
        include "pages/ubahprofil.php";
        break;
    case "ubahpassword":
        include "pages/ubahpassword.php";
        break;

    case "laporanpermintaanbarang":
        include "pages/report/laporanpermintaan.php";
        break;
    case "exportlaporanpermintaan":
        include "pages/report/exportpermintaanbarang.php";
        break;
    case "pengadaanbarang":
        include "pages/pengadaan/pengadaan.php";
        break;
    case "pengadaantambah":
        include "pages/pengadaan/pengadaantambah.php";
        break;
    case "pengadaanubah":
        include "pages/pengadaan/pengadaanubah.php";
        break;
    case "exportpengadaanbarang":
        include "pages/report/exportpengadaanbarang.php";
        break;

        
    default:
        include "pages/404.php";
}