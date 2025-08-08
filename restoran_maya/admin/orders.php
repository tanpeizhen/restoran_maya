<?php
session_start();
include '../db.php';

$sql = "
SELECT 
    o.id, o.nama_pelanggan, o.phone, o.payment_method, o.total_amount, o.created_at,
    m.nama AS menu_nama,
    oi.kuantiti
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN menu m ON oi.menu_id = m.id
ORDER BY o.created_at DESC
";

$result = mysqli_query($conn, $sql);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $order_id = $row['id'];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'nama_pelanggan' => $row['nama_pelanggan'],
            'phone' => $row['phone'],
            'payment_method' => $row['payment_method'],
            'total_amount' => $row['total_amount'],
            'created_at' => $row['created_at'],
            'items' => []
        ];
    }
    $orders[$order_id]['items'][] = [
        'menu_nama' => $row['menu_nama'],
        'kuantiti' => $row['kuantiti']
    ];
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Senarai Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h1>📋 Senarai Pesanan</h1>
    <?php if (empty($orders)): ?>
        <p>Tiada pesanan ditemui.</p>
    <?php else: ?>
        <?php foreach ($orders as $order_id => $order): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Pesanan #<?= $order_id ?></strong> — <?= htmlspecialchars($order['nama_pelanggan']) ?><br>
                    Telefon: <?= htmlspecialchars($order['phone']) ?><br>
                    Cara Bayar: <?= htmlspecialchars($order['payment_method']) ?><br>
                    Jumlah: RM <?= number_format($order['total_amount'], 2) ?><br>
                    Tarikh: <?= $order['created_at'] ?>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($order['items'] as $item): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($item['menu_nama']) ?> × <?= intval($item['kuantiti']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
