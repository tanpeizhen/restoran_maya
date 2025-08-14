<?php
session_start();
include 'db.php';

if (!isset($_SESSION['last_order_id'])) {
    echo "Tiada resit untuk dipaparkan.";
    exit;
}

$order_id = $_SESSION['last_order_id'];

// Dapatkan maklumat pesanan
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "Pesanan tidak ditemui.";
    exit;
}

// Dapatkan butiran item pesanan termasuk catatan
$stmt_items = $conn->prepare("
    SELECT m.nama, oi.kuantiti, m.harga, oi.remark AS catatan, (oi.kuantiti * m.harga) AS subtotal
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
    <meta charset="UTF-8">
    <title>Resit Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #FF7043 0%, #FFCCBC 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 50px;
        }
        .receipt-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.25);
        }
        h2 {
            color: #D84315;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px #FFAB91;
        }
        h5 {
            color: #E64A19;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #FF7043;
            padding-bottom: 5px;
        }
        .table th {
            background-color: #FFEFDB;
        }
        .btn-custom {
            background-color: #D84315;
            color: white;
            border-radius: 40px;
            padding: 12px 40px;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
        .btn-custom:hover {
            background-color: #BF360C;
            color: white;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h2>🧾 Resit Pesanan Anda</h2>

        <h5>Maklumat Pelanggan</h5>
        <p><strong>Nama:</strong> <?= htmlspecialchars($order['nama_pelanggan']) ?></p>
        <p><strong>Telefon:</strong> <?= htmlspecialchars($order['telefon']) ?></p>
        <p><strong>Kaedah Pembayaran:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p><strong>Tarikh Pesanan:</strong> <?= $order['created_at'] ?></p>

        <h5>Butiran Pesanan</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Kuantiti</th>
                    <th>Harga (RM)</th>
                    <th>Catatan</th>
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
                    <td><?= htmlspecialchars($item['catatan']) ?: '-' ?></td>
                    <td><?= number_format($item['subtotal'], 2) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Jumlah Keseluruhan</th>
                    <th>RM <?= number_format($total, 2) ?></th>
                </tr>
            </tfoot>
        </table>

        <a href="order.php" class="btn-custom">Kembali ke Halaman Pesanan</a>
    </div>
</body>
</html>
