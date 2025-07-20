<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>APLIKASI PERSEDIAAN DAN MONITORING BARANG</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-image: url("assets/images/pariwisata.jpg");
      background-size: cover;
      background-repeat: no-repeat;

    }

    .bd-placeholder-img {
      font-size: 1.100rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="assets/css/login.css" rel="stylesheet">
</head>

<body class="text-center">
  <main class="form-signin">
    <form method="post">
      <img class="mb-3" src="assets/images/prov.png" alt="" width="150" height="150">
      <h1 class="h3 mb-3 fw-normal"></h1>
      <p class="mb-3 fw-normal">APLIKASI PENGALOLAAN DAN MONITORING DINAS PARIWISATA</p>
      <?php
      include_once "libraries/koneksi.php";
      if (isset($_POST["login_button"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $loginSQL = "SELECT * FROM user WHERE username='$username' AND password=MD5('$password')";
        $resultSetLogin = mysqli_query($koneksi, $loginSQL);
        $ada = (mysqli_num_rows($resultSetLogin) > 0) ? true : false;
        if ($ada) {
          $rowCari = mysqli_fetch_assoc($resultSetLogin);
          $_SESSION["id_user"] = $rowCari["id"];
          $_SESSION["nama_pegawai"] = $rowCari["nama_pegawai"];
          $_SESSION["level"] = $rowCari["level"];
        } else {
      ?>
          <div class="alert alert-danger" role="alert">
            <i class="fa fa-ban"></i>
            Gagal Login
          </div>
      <?php
        }
      }

      if (isset($_SESSION["id_user"])) {
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";
      }
      ?>

      <div class="form-floating">
        <input type="username" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" required>
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit" name="login_button">Submit</button>
    </form>
  </main>
</body>

</html>