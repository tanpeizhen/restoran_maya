<?php
session_start();
include 'db.php';

if (!isset($_SESSION['last_order_id'])) {
    echo "Tiada resit untuk dipaparkan.";
    exit;
}

$order_id = $_SESSION['last_order_id'];

// 获取订单信息
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemui.";
    exit;
}

// 获取订单明细
$stmt_items = $conn->prepare("
    SELECT m.nama, oi.kuantiti, m.harga, (oi.kuantiti * m.harga) AS subtotal
    FROM order_items oi
    JOIN menu m ON oi.menu_id = m.id
    WHERE oi.order_id = ?
");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items_result = $stmt_items->get_result();

?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Resit Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">🧾 Resit Pesanan Anda</h2>

    <div class="card p-4 mb-4">
        <h5>Maklumat Pelanggan</h5>
        <p><strong>Nama:</strong> <?= htmlspecialchars($order['nama_pelanggan']) ?></p>
        <p><strong>Telefon:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p><strong>Kaedah Pembayaran:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p><strong>Tarikh Pesanan:</strong> <?= $order['created_at'] ?></p>
    </div>

    <h5>Butiran Pesanan</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Kuantiti</th>
                <th>Harga (RM)</th>
                <th>Jumlah (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            while ($item = $items_result->fetch_assoc()):
                $total += $item['subtotal'];
            ?>
            <tr>
                <td><?= htmlspecialchars($item['nama']) ?></td>
                <td><?= $item['kuantiti'] ?></td>
                <td><?= number_format($item['harga'], 2) ?></td>
                <td><?= number_format($item['subtotal'], 2) ?></td>
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

    <a href="order.php" class="btn btn-primary">Kembali ke Halaman Pesanan</a>
</div>
</body>
</html>
