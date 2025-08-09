<?php
// menu_add.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';

$success = "";
$error = "";

// 如果有表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];

    // 上传图片处理
    $imej = '';
    if (isset($_FILES['imej']) && $_FILES['imej']['error'] == 0) {
        $target_dir = "../uploads/";
        $imej = basename($_FILES["imej"]["name"]);
        $target_file = $target_dir . $imej;
        move_uploaded_file($_FILES["imej"]["tmp_name"], $target_file);
    }

    // 插入数据库
    $stmt = $conn->prepare("INSERT INTO menu (nama, harga, kategori, imej) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $nama, $harga, $kategori, $imej);

    if ($stmt->execute()) {
        $success = "Menu berjaya ditambah!";
    } else {
        $error = "Gagal tambah menu: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">🍽️ Tambah Menu Baharu</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="menu_add.php" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga (RM)</label>
            <input type="number" step="0.01" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" required placeholder="Contoh: Minuman / Makanan">
        </div>
        <div class="mb-3">
            <label class="form-label">Muat Naik Gambar</label>
            <input type="file" name="imej" class="form-control">
        </div>
        <button type="submit" class="btn btn-success btn-lg">+ Tambah Menu</button>
        <a href="menu_manage.php" class="btn btn-secondary btn-lg">Kembali</a>
    </form>
</div>
</body>
</html>
