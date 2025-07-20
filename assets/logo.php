<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegant Logo</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .logo {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .logo img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .description {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="assets/images/wonderfull.jpg" alt="Logo">
    </div>
    <h1 class="title">APLIKASI PERSEDIAAN DAN MONITORING BARANG</h1>
    <p class="description">Sistem untuk mengelola dan memantau persediaan barang dengan mudah.</p>
</body>
</html>
