<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

if (!isset($_GET['id'])) {
    die("ID menu tidak diberikan.");
}

$id = (int) $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM menu WHERE id=$id");
$menu = mysqli_fetch_assoc($result);
if (!$menu) {
    die("Menu tidak dijumpai.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $imej = $menu['imej'];

    if (!empty($_FILES['imej']['name'])) {
        $file_name = basename($_FILES["imej"]["name"]);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["imej"]["tmp_name"], $target_file)) {
            $imej = $file_name;
        }
    }

    $stmt = $conn->prepare("UPDATE menu SET nama=?, harga=?, kategori=?, imej=? WHERE id=?");
    $stmt->bind_param("sdssi", $nama, $harga, $kategori, $imej, $id);
    $stmt->execute();

    header("Location: menu_manage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:600px;">
    <h2 class="mb-4 text-center">✏️ Edit Menu</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm bg-white border">
        <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($menu['nama']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (RM)</label>
            <input type="number" step="0.01" name="harga" value="<?= htmlspecialchars($menu['harga']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($menu['kategori']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Imej Sekarang</label><br>
            <?php if (!empty($menu['imej'])): ?>
                <img src="../uploads/<?= htmlspecialchars($menu['imej']) ?>" width="150" class="img-thumbnail mb-2">
            <?php else: ?>
                <p class="text-muted">Tiada imej</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Tukar Imej</label>
            <input type="file" name="imej" class="form-control">
            <div class="form-text">Boleh dibiarkan kosong jika tidak mahu tukar gambar</div>
        </div>

        <button type="submit" class="btn btn-success w-100">💾 Simpan Perubahan</button>
        <a href="menu_manage.php" class="btn btn-secondary mt-2 w-100">Kembali</a>
    </form>
</div>
</body>
</html>
