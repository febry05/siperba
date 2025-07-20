<nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
    <div class="d-flex align-items-center">
        <i class="fas fa-align-left second-text fs-4 me-3" id="menu-toggle"></i>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user me-2"></i>
                    <?php echo isset($_SESSION["level"]) ? '' . $_SESSION["level"] . '|' : '' ?>
                    <?= isset($_SESSION["nama_pegawai"]) ? $_SESSION["nama_pegawai"] : ""; ?>

                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="?page=ubahprofil">Profil</a></li>
                    <li><a class="dropdown-item" href="?page=ubahpassword">Ubah Password</a></li>
                    <li>
                        <form action="" method="post">
                            <button name="logout_button" type="submit" onclick="javascript: return confirm('Yakin keluar?');" class="dropdown-item">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>