<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: ../login.php");
  exit();
}
include '../db.php';

// 更新订单状态
if (isset($_POST['update_status'])) {
  $order_id = intval($_POST['order_id']);
  $status = $_POST['status'];
  $status = mysqli_real_escape_string($conn, $status);
  mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$order_id");
  header("Location: orders_manage.php");
  exit();
}

$orders = mysqli_query($conn, "SELECT o.id, o.nama_pelanggan, m.nama AS menu_nama, o.status 
                               FROM orders o 
                               LEFT JOIN menu m ON o.menu_id = m.id
                               ORDER BY o.id DESC");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8" />
  <title>Urus Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h1>📋 Urus Pesanan</h1>
    <table class="table table-bordered bg-white">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nama Pelanggan</th>
          <th>Menu</th>
          <th>Status</th>
          <th>Tindakan</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($orders)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
          <td><?= htmlspecialchars($row['menu_nama']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td>
            <form method="POST" class="d-flex gap-2">
              <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
              <select name="status" class="form-select form-select-sm" required>
                <option value="Belum Selesai" <?= $row['status']=='Belum Selesai' ? 'selected' : '' ?>>Belum Selesai</option>
                <option value="Sedang Diproses" <?= $row['status']=='Sedang Diproses' ? 'selected' : '' ?>>Sedang Diproses</option>
                <option value="Selesai" <?= $row['status']=='Selesai' ? 'selected' : '' ?>>Selesai</option>
              </select>
              <button type="submit" name="update_status" class="btn btn-primary btn-sm">Kemaskini</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <a href="menu_manage.php" class="btn btn-outline-primary">Urus Menu</a>
    <a href="logout.php" class="btn btn-outline-secondary ms-2">Logout</a>
  </div>
</body>
</html>
