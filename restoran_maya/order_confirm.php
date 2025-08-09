<?php
include 'db.php';

if (!isset($_GET['order_id'])) {
    echo "ID pesanan tidak sah.";
    exit;
}

$order_id = intval($_GET['order_id']);

// 取订单基本信息
$order_res = mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id");
$order = mysqli_fetch_assoc($order_res);

if (!$order) {
    echo "Pesanan tidak ditemui.";
    exit;
}

// 取订单项和菜单详情
$sql = "SELECT oi.kuantiti, m.nama, m.harga 
        FROM order_items oi 
        JOIN menu m ON oi.menu_id = m.id 
        WHERE oi.order_id = $order_id";
$items_res = mysqli_query($conn, $sql);

$total = 0;
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8" />
  <title>Sahkan Pesanan - Restoran Maya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h1 {
      margin-bottom: 20px;
      font-weight: 700;
      color: #343a40;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Terima Kasih atas Pesanan Anda!</h1>
    <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($order['nama_pelanggan']) ?></p>
    <p><strong>ID Pesanan:</strong> <?= $order_id ?></p>

    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Nama Menu</th>
          <th>Kuantiti</th>
          <th>Harga Seunit (RM)</th>
          <th>Jumlah (RM)</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = mysqli_fetch_assoc($items_res)) : 
          $subtotal = $item['kuantiti'] * $item['harga'];
          $total += $subtotal;
        ?>
        <tr>
          <td><?= htmlspecialchars($item['nama']) ?></td>
          <td><?= $item['kuantiti'] ?></td>
          <td><?= number_format($item['harga'], 2) ?></td>
          <td><?= number_format($subtotal, 2) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-end">Jumlah Keseluruhan</th>
          <th>RM <?= number_format($total, 2) ?></th>
        </tr>
      </tfoot>
    </table>

    <div class="text-center">
      <a href="index.html" class="btn btn-primary">Kembali ke Halaman Utama</a>
      <a href="order.php" class="btn btn-outline-secondary ms-2">Buat Pesanan Baru</a>
    </div>
  </div>
</body>
</html>
