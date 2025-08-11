<?php
session_start();
include '../db.php';

// 如果没登录直接跳去 login.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 查询菜单
$result = $conn->query("SELECT * FROM menu ORDER BY kategori, nama");
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pengurusan Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        .container {
            margin-top: 30px;
        }
        .btn-tambah {
            font-size: 1.2rem;
            padding: 15px 25px;
            background-color: #28a745;
            border: none;
        }
        .btn-tambah:hover {
            background-color: #218838;
        }
        table {
            background: white;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        img {
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">📋 Pengurusan Menu Restoran</h2>

    <div class="text-end mb-3">
        <a href="menu_add.php" class="btn btn-tambah text-white">➕ Tambah Makanan</a>
    </div>

    <table class="table table-bordered table-striped text-center align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga (RM)</th>
                <th>Gambar</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= number_format($row['harga'], 2) ?></td>
                <td>
                    <?php if (!empty($row['imej'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($row['imej']) ?>" width="80">
                    <?php else: ?>
                        <span class="text-muted">Tiada gambar</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="menu_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="menu_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Padam item ini?')">Padam</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="mt-4 text-center">
        <a href="orders_manage.php" class="btn btn-primary">📦 Lihat Pesanan</a>
        <a href="logout.php" class="btn btn-secondary">🚪 Log Keluar</a>
    </div>
</div>
</body>
</html>
