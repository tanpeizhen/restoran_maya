<?php
session_start();
include '../db.php';

// 简单登录验证，防止未登录访问
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 获取菜单数据
$result = mysqli_query($conn, "SELECT * FROM menu ORDER BY kategori, nama");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Pengurusan Menu - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">📋 Senarai Menu</h1>
    <a href="menu_add.php" class="btn btn-success mb-3">+ Tambah Menu Baru</a>
    <a href="dashboard.php" class="btn btn-secondary mb-3 ms-2">← Dashboard</a>

    <table class="table table-bordered table-striped bg-white shadow-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga (RM)</th>
                <th>Imej</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($menu = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($menu['id']) ?></td>
                <td><?= htmlspecialchars($menu['nama']) ?></td>
                <td><?= htmlspecialchars($menu['kategori']) ?></td>
                <td><?= number_format($menu['harga'], 2) ?></td>
                <td>
                    <?php if ($menu['imej'] && file_exists("../uploads/" . $menu['imej'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($menu['imej']) ?>" alt="<?= htmlspecialchars($menu['nama']) ?>" style="height: 50px;">
                    <?php else: ?>
                        Tiada Imej
                    <?php endif; ?>
                </td>
                <td>
                    <a href="menu_edit.php?id=<?= $menu['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="menu_delete.php?id=<?= $menu['id'] ?>" onclick="return confirm('Anda pasti mahu padam menu ini?');" class="btn btn-danger btn-sm">Padam</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
