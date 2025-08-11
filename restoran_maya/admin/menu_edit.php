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

// 获取所有类别
$kategori_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM menu ORDER BY kategori");
$kategori_list = [];
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategori_list[] = $row['kategori'];
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $imej = $menu['imej'];

    if (!empty($_FILES['imej']['name'])) {
        $imej = $_FILES['imej']['name'];
        $target = "../uploads/" . basename($imej);
        move_uploaded_file($_FILES['imej']['tmp_name'], $target);
    }

    $sql = "UPDATE menu SET nama='$nama', harga=$harga, imej='$imej', kategori='$kategori' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: menu_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8" />
  <title>Edit Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #FF7043 0%, #FFCCBC 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 40px;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(255, 112, 67, 0.4);
      max-width: 600px;
      margin: auto;
      background: white;
    }
    h2 {
      color: #D84315;
      font-weight: 700;
      text-align: center;
      margin-bottom: 30px;
      text-shadow: 1px 1px 4px #FFAB91;
    }
    label {
      font-weight: 600;
      color: #BF360C;
    }
    .form-control, .form-select {
      border-radius: 10px;
      box-shadow: inset 0 0 8px rgba(255, 112, 67, 0.2);
      transition: box-shadow 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
      box-shadow: 0 0 8px #D84315;
      border-color: #D84315;
      outline: none;
    }
    .btn-primary {
      background-color: #D84315;
      border: none;
      padding: 12px 30px;
      font-size: 1.2rem;
      border-radius: 50px;
      box-shadow: 0 6px 15px rgba(216, 67, 21, 0.6);
      transition: background-color 0.3s ease;
      width: 100%;
    }
    .btn-primary:hover {
      background-color: #BF360C;
      box-shadow: 0 8px 20px rgba(191, 54, 12, 0.8);
    }
    .btn-secondary {
      border-radius: 50px;
      padding: 10px 25px;
      font-size: 1rem;
      margin-top: 15px;
      width: 100%;
    }
    img.menu-img {
      border-radius: 12px;
      max-width: 150px;
      box-shadow: 0 4px 15px rgba(216, 67, 21, 0.3);
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="card p-4">
    <h2>Edit Menu</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="nama">Nama Menu</label>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($menu['nama']) ?>" class="form-control" required />
      </div>
      <div class="mb-4">
        <label for="harga">Harga (RM)</label>
        <input type="number" step="0.01" id="harga" name="harga" value="<?= $menu['harga'] ?>" class="form-control" required />
      </div>
      <div class="mb-4">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori" class="form-select" required>
          <?php foreach ($kategori_list as $kat): ?>
            <option value="<?= htmlspecialchars($kat) ?>" <?= ($kat === $menu['kategori']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($kat) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4 text-center">
        <label>Imej Sekarang</label><br>
        <img src="../uploads/<?= htmlspecialchars($menu['imej']) ?>" alt="Imej Menu" class="menu-img" /><br />
        <input type="file" name="imej" class="form-control" />
        <small class="text-muted">Boleh dibiarkan kosong jika tidak mahu tukar gambar</small>
      </div>
      <button type="submit" name="update" class="btn btn-primary">Simpan</button>
      <a href="menu_manage.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>
</html>
