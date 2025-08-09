<?php
session_start();
include 'db.php';

// 如果没有订单数据，返回订单页
if (!isset($_SESSION['order_items']) || empty($_SESSION['order_items'])) {
    header("Location: order.php");
    exit;
}

$order_items = $_SESSION['order_items'];

// 计算总价
$total = 0;
foreach ($order_items as $item) {
    $total += $item['harga'] * $item['kuantiti'];
}

// 如果点击了 "Bayar Sekarang"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'] ?? 'Pelanggan';
    $phone = $_POST['phone'] ?? '';
    $payment_method = $_POST['payment_method'] ?? 'Tunai';

    // 1️⃣ 保存订单主表
    $stmt = $conn->prepare("INSERT INTO orders (nama_pelanggan, phone, payment_method, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $nama_pelanggan, $phone, $payment_method);
    if (!$stmt->execute()) {
        die("Gagal menyimpan pesanan: " . $stmt->error);
    }
    $order_id = $stmt->insert_id;

    // 2️⃣ 保存订单明细
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, menu_id, kuantiti) VALUES (?, ?, ?)");
    foreach ($order_items as $menu_id => $item) {
        $stmt_item->bind_param("iii", $order_id, $menu_id, $item['kuantiti']);
        if (!$stmt_item->execute()) {
            die("Gagal menyimpan item pesanan: " . $stmt_item->error);
        }
    }

    // 3️⃣ 清理 session 并存 order_id
    unset($_SESSION['order_items']);
    $_SESSION['last_order_id'] = $order_id;

    // 4️⃣ 跳转到收据页
    header("Location: receipt.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #FF7043 0%, #FFCCBC 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            text-shadow: 1px 1px 4px #FFAB91;
        }
        .btn-pay {
            background: #D84315;
            border: none;
            color: #fff;
            font-size: 1.4rem;
            padding: 14px 40px;
            border-radius: 40px;
            box-shadow: 0 6px 15px rgba(216, 67, 21, 0.6);
            transition: background 0.3s ease;
            display: inline-block;
            margin-top: 30px;
            cursor: pointer;
        }
        .btn-pay:hover {
            background: #BF360C;
            box-shadow: 0 8px 20px rgba(191, 54, 12, 0.8);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Butiran Pesanan & Pembayaran</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Kuantiti</th>
                <th>Harga Seunit (RM)</th>
                <th>Jumlah (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama']) ?></td>
                    <td><?= $item['kuantiti'] ?></td>
                    <td><?= number_format($item['harga'], 2) ?></td>
                    <td><?= number_format($item['harga'] * $item['kuantiti'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="text-end"><strong>Jumlah Keseluruhan</strong></td>
                <td><strong><?= number_format($total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>

    <form method="post" class="text-center">
        <div class="mb-3">
            <input type="text" name="nama_pelanggan" placeholder="Nama" required class="form-control" />
        </div>
        <div class="mb-3">
            <input type="text" name="phone" placeholder="Telefon" required class="form-control" />
        </div>
        <div class="mb-3">
            <select name="payment_method" class="form-control" required>
                <option value="Tunai">Tunai</option>
                <option value="Kad Kredit/Debit">Kad Kredit/Debit</option>
                <option value="E-Wallet">E-Wallet</option>
            </select>
        </div>
        <button type="submit" class="btn-pay">Bayar Sekarang</button>
    </form>
</div>
</body>
</html>
