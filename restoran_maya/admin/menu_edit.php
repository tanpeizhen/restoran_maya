<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM menu WHERE id = $id");
$menu = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $imej = $menu['imej'];

    // 如果上传了新图片
    if (!empty($_FILES['imej']['name'])) {
        $imej = $_FILES['imej']['name'];
        $target = "../uploads/" . basename($imej);
        move_uploaded_file($_FILES['imej']['tmp_name'], $target);
    }

    mysqli_query($conn, "UPDATE menu SET nama='$nama', harga=$harga, imej='$imej' WHERE id=$id");
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
  <div class="container mt-5" style="max-width: 600px;">
    <h2>Edit Menu</h2>
    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow">
      <div class="mb-3">
        <label>Nama Menu</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($menu['nama']) ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Harga</label>
        <input type="number" step="0.01" name="harga" value="<?= $menu['harga'] ?>" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Imej Sekarang</label><br>
        <img src="../uploads/<?= $menu['imej'] ?>" width="100"><br><br>
        <input type="file" name="imej" class="form-control">
        <small class="text-muted">Boleh dibiarkan kosong jika tidak mahu tukar gambar</small>
      </div>
      <button type="submit" name="update" class="btn btn-primary">Simpan</button>
      <a href="menu_manage.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>
</html>
