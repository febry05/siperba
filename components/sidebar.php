<?php
$menu = array(
    "dashboard" => "fw-bold",
    "user" => "fw-bold",
    "stokbarang" => "fw-bold",
    "barangmasuk" => "fw-bold",
    "barangkeluar" => "fw-bold",
    "permintaan" => "fw-bold",
    "pengadaan" => "fw-bold",
    "retur" => "fw-bold",
    "master" => "fw-bold",
    "report" => "fw-bold"

);

$collapse = array(
    "master" => "",
    "report" => "",

);

$sub = array(
    "divisi" => "link-dark",
    "pegawai" => "link-dark",
    "supplier" => "link-dark",
    "barang" => "link-dark",

);

$page = (isset($_GET["page"])) ? $_GET["page"] : $page = "";

switch ($page) {
    case "":
    case "dashboard":
    case "profil":
    case "ubahpassword":
        $menu["dashboard"] = "active";
        break;
    case "stokbarangdata":
    case "stokbarangtambah":
    case "stokbarangubah":
        $menu["stokbarang"] = "active";
        break;
    case "divisidata":
    case "divisitambah":
    case "divisiubah":
        $menu["master"] = "active";
        $collapse["master"] = "show";
        $sub["divisi"] = "link-success";
        break;
    case "pegawaidata":
    case "pegawaitambah":
    case "pegawaiubah":
        $menu["master"] = "active";
        $collapse["master"] = "show";
        $sub["pegawai"] = "link-success";
        break;
    case "supplierdata":
    case "suppliertambah":
    case "supplierubah":
        $menu["master"] = "active";
        $collapse["master"] = "show";
        $sub["supplier"] = "link-success";
        break;
    case "barangdata":
    case "barangtambah":
    case "barangubah":
        $menu["master"] = "active";
        $collapse["master"] = "show";
        $sub["barang"] = "link-success";
        break;
    case "barangmasukdata":
    case "barangmasuktambah":
    case "barangmasukubah":
        $menu["barangmasuk"] = "active";
        break;
    case "barangkeluardata":
    case "barangkeluartambah":
    case "barangkeluarubah":
        $menu["barangkeluar"] = "active";
        break;
    case "permintaandata":
    case "permintaantambah":
    case "permintaanubah":
    case "disetujui":
    case "tidaksetuju":
        $menu["permintaan"] = "active";
        break;

    case "pengadaanbarang":
    case "pengadaantambah":
    case "pengadaanubah":
    case "disetujui":
    case "tidaksetuju":
        $menu["pengadaan"] = "active";
        break;
    case "returdata":
    case "returtambah":
    case "returdetail":
    case "returubah":
        $menu["retur"] = "active";
        break;
    case "userdata":
    case "usertambah":
    case "userubah":
        $menu["user"] = "active";
        break;
    default:
        include "pages/404.php";
}

?>
<div class="bg-white" id="sidebar-wrapper">
    <div class="d-flex align-items-center py-3 primary-text fs- fw-bold text-uppercase border-bottom">
        <img src="assets/images/wonderfull.jpg" alt="Icon Aplikasi" class="me-4" style="width: 70px; height: 70px;">
        <span style="color:black;">APLIKASI PENGELOLAAN DAN MONITORING BARANG</span>
    </div>



    <div class="list-group list-group-flush my-3">
        <a href="index.php"
            class="list-group-item list-group-item-action bg-transparent abu-text  <?= $menu["dashboard"] ?>"><i
                class="fas fa-tachometer-alt me-2"></i>Dashboard</a>

        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Admin") : ?>
        <button class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["master"] ?>"
            data-bs-toggle="collapse" data-bs-target="#master-collapse" aria-expanded="true">
            <i class="fas fa-list me-2"></i>Data Master
        </button>
        <div class="collapse  <?= $collapse["master"] ?>" id="master-collapse">
            <ul class="btn-toggle-nav list-unstyled ps-4">
                <li><a href="?page=barangdata" class="<?= $sub["barang"] ?> rounded">Barang</a></li>
                <li><a href="?page=pegawaidata" class="<?= $sub["pegawai"] ?> rounded">Pegawai</a></li>
                <li><a href="?page=supplierdata" class="<?= $sub["supplier"] ?> rounded">Supplier</a></li>
                <li><a href="?page=divisidata" class="<?= $sub["divisi"] ?> rounded">Divisi</a></li>
            </ul>
        </div>
        <?php endif; ?>


        <a href="?page=stokbarangdata"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["stokbarang"] ?>"><i
                class="fas fa-database me-2"></i>Data Stok Barang</a>
        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Admin") : ?>
        <a href="?page=barangmasukdata"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["barangmasuk"] ?>"><i
                class="fas fa-share me-2"></i>Barang Masuk</a>
        <a href="?page=barangkeluardata"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["barangkeluar"] ?>"><i
                class="fas fa-share fa-flip-horizontal me-2"></i>Barang Keluar</a>
        <?php endif; ?>

        <a href="?page=permintaandata"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["permintaan"] ?>"><i
                class="fas fa-cart-shopping me-2"></i>Permintaan Barang</a>
        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Admin") : ?>
        <a href="?page=returdata"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["retur"] ?>"><i
                class="fas fa-cart-shopping me-2"></i>Retur Barang</a>
        <?php endif; ?>
        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Admin") : ?>
        <a href="?page=userdata"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["user"] ?>">
            <i class="fas fa-users me-2"></i>Admin
        </a>
        <?php endif; ?>


        <a href="?page=pengadaanbarang"
            class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["pengadaan"] ?>"><i
                class="fas fa-cart-shopping me-2"></i>Pengadaan Barang</a>


        <?php if (isset($_SESSION["level"]) && $_SESSION["level"] == "Admin") : ?>
        <button class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["report"] ?>"
            data-bs-toggle="collapse" data-bs-target="#report-collapse" aria-expanded="true">
            <i class="fas fa-print me-2"></i>Report
        </button>
        <div class="collapse  <?= $collapse["report"] ?>" id="report-collapse">
            <ul class="btn-toggle-nav list-unstyled ps-4">
                <li><a href="?page=laporanpermintaanbarang" class="<?= $sub["barang"] ?> rounded">Laporan </a></li>

            </ul>
        </div>
        <?php endif; ?>


        <form action="" method="post">
            <button name="logout_button" type="submit" onclick="javascript: return confirm('Yakin keluar?');"
                class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                <i class="fas fa-power-off me-2"></i>Logout
            </button>
        </form>
    </div>
</div>
<!-- /#sidebar-wrapper -->