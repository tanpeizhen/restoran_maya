<?php
session_start();
include 'db.php';

// 检查是否有订单
if (!isset($_SESSION['order_items']) || empty($_SESSION['order_items'])) {
    header("Location: order.php");
    exit;
}

$order_items = $_SESSION['order_items'];
$error = "";

// 处理提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $telefon = trim($_POST['telefon']);
    $payment_method = trim($_POST['payment_method']);

    if (empty($nama) || empty($telefon) || empty($payment_method)) {
        $error = "Sila isi semua maklumat.";
    } else {
        // 计算总金额
        $total_amount = 0;
        foreach ($order_items as $item) {
            $total_amount += $item['harga'] * $item['kuantiti'];
        }

        // 插入订单
        $stmt = $conn->prepare("INSERT INTO orders (nama_pelanggan, telefon, payment_method, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $nama, $telefon, $payment_method, $total_amount);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // 插入订单明细
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, menu_id, kuantiti, remark) VALUES (?, ?, ?, ?)");
        foreach ($order_items as $menu_id => $item) {
            $stmt_item->bind_param("iiis", $order_id, $menu_id, $item['kuantiti'], $item['remark']);
            $stmt_item->execute();
        }

        $_SESSION['last_order_id'] = $order_id;
        unset($_SESSION['order_items']);
        header("Location: receipt.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #FF7043 0%, #FFCCBC 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 50px;
        }
        .container {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            margin-top: 40px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.25);
        }
        h2 {
            color: #D84315;
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px #FFAB91;
        }
        .form-label {
            font-weight: 600;
            color: #BF360C;
        }
        .form-control {
            border-radius: 12px;
        }
        .btn-pay {
            background: #D84315;
            border: none;
            color: #fff;
            font-size: 1.4rem;
            padding: 12px 40px;
            border-radius: 40px;
            margin-top: 20px;
            display: block;
            width: 100%;
            transition: background 0.3s ease;
        }
        .btn-pay:hover {
            background: #BF360C;
        }
        .alert {
            text-align: center;
            font-weight: 600;
        }
        .order-summary {
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .order-summary th {
            background-color: #FFEFDB;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Pembayaran Pesanan</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nama Penuh</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombor Telefon</label>
            <input type="text" name="telefon" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kaedah Pembayaran</label>
            <select name="payment_method" class="form-control" required>
                <option value="">-- Pilih Kaedah --</option>
                <option value="Tunai">Tunai</option>
                <option value="Kad Kredit">Kad Kredit</option>
                <option value="Online Banking">Online Banking</option>
            </select>
        </div>

        <h4 class="mt-4">Ringkasan Pesanan</h4>
        <table class="table table-bordered order-summary">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Kuantiti</th>
                    <th>Harga (RM)</th>
                    <th>Catatan</th>
                    <th>Subtotal (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; foreach ($order_items as $item): 
                    $subtotal = $item['harga'] * $item['kuantiti'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama']) ?></td>
                    <td><?= $item['kuantiti'] ?></td>
                    <td><?= number_format($item['harga'],2) ?></td>
                    <td><?= htmlspecialchars($item['remark']) ?: '-' ?></td>
                    <td><?= number_format($subtotal,2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Jumlah Keseluruhan</th>
                    <th>RM <?= number_format($total,2) ?></th>
                </tr>
            </tfoot>
        </table>

        <button type="submit" class="btn btn-pay">Bayar Sekarang</button>
    </form>
</div>
</body>
</html>
