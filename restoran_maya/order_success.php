<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: order.php");
    exit();
}

$order_id = intval($_GET['id']);

// Dapatkan maklumat pesanan
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Pesanan tidak wujud!");
}

// Dapatkan senarai item
$stmt_items = $conn->prepare("
    SELECT m.nama, m.harga, oi.quantity 
    FROM order_items oi
    JOIN menu m ON oi.menu_id = m.id
    WHERE oi.order_id = ?
");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Butiran Pesanan - #<?= $order_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>✅ Pembayaran Berjaya! Nombor Pesanan: #<?= $order_id ?></h4>
        </div>
        <div class="card-body">
            <h5>Maklumat Pelanggan</h5>
            <p>Nama: <?= htmlspecialchars($order['customer_name']) ?></p>
            <p>No. Telefon: <?= htmlspecialchars($order['phone']) ?></p>
            <p>Kaedah Bayaran: <?= htmlspecialchars($order['payment_method']) ?></p>

            <hr>
            <h5>Senarai Makanan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Makanan</th>
                        <th>Harga</th>
                        <th>Kuantiti</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $items->fetch_assoc()) {
                        $subtotal = $row['harga'] * $row['quantity'];
                        echo "<tr>
                                <td>{$row['nama']}</td>
                                <td>RM " . number_format($row['harga'], 2) . "</td>
                                <td>{$row['quantity']}</td>
                                <td>RM " . number_format($subtotal, 2) . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h4 class="text-end">Jumlah Keseluruhan: RM <?= number_format($order['total_amount'], 2) ?></h4>
            <a href="order.php" class="btn btn-primary mt-3">Kembali ke Halaman Pesanan</a>
        </div>
    </div>
</div>
</body>
</html>
