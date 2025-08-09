<?php
session_start();

// 如果没登录就跳回登录页
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Restoran Maya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #ffecd2, #fcb69f);
            font-family: 'Segoe UI', sans-serif;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .btn-custom {
            width: 200px;
            margin: 15px;
            font-size: 18px;
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h1 class="mb-4">📋 Selamat Datang, Admin!</h1>
    <p class="mb-4">Pilih tindakan yang anda mahu lakukan:</p>

    <div>
        <a href="menu.php" class="btn btn-success btn-custom">🍽️ Tambah Menu</a>
        <a href="orders.php" class="btn btn-primary btn-custom">📦 Lihat Pesanan</a>
    </div>
    <div>
        <a href="logout.php" class="btn btn-danger btn-custom">🚪 Log Keluar</a>
    </div>
</div>

</body>
</html>
