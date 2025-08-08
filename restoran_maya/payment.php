<?php
session_start();
include 'db.php';

// 确认订单存在
if (!isset($_SESSION['order_items']) || empty($_SESSION['order_items']['kuantiti'])) {
    echo "<p>Tiada pesanan untuk dibayar.</p>";
    exit;
}

$order_items = $_SESSION['order_items'];
$error = '';
$nama = $_POST['nama'] ?? '';
$phone = $_POST['phone'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    $nama = trim($_POST['nama']);
    $phone = trim($_POST['phone']);
    $payment_method = $_POST['payment_method'];

    if ($nama === '') {
        $error = "Sila masukkan nama anda.";
    } elseif ($payment_method === '') {
        $error = "Sila pilih kaedah pembayaran.";
    } else {
        // 计算总金额
        $total_amount = 0;
        foreach ($order_items['kuantiti'] as $menu_id => $qty) {
            $menu_id = intval($menu_id);
            $qty = intval($qty);
            if ($qty > 0) {
                $res = $conn->query("SELECT harga FROM menu WHERE id = $menu_id");
                if ($row = $res->fetch_assoc()) {
                    $total_amount += $row['harga'] * $qty;
                }
            }
        }

        // 插入订单表
        $stmt = $conn->prepare("INSERT INTO orders (nama_pelanggan, phone, payment_method, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $nama, $phone, $payment_method, $total_amount);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // 插入订单明细
        $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, menu_id, kuantiti) VALUES (?, ?, ?)");
        foreach ($order_items['kuantiti'] as $menu_id => $qty) {
            $menu_id = intval($menu_id);
            $qty = intval($qty);
            if ($qty > 0) {
                $stmt2->bind_param("iii", $order_id, $menu_id, $qty);
                $stmt2->execute();
            }
        }

        // 清理订单session，保存order_id用于显示收据
        unset($_SESSION['order_items']);
        $_SESSION['last_order_id'] = $order_id;

        // 跳转到收据页面
        header("Location: receipt.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Sahkan Pembayaran Anda</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No Telefon</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" placeholder="Contoh: 0123456789">
        </div>

        <div class="mb-3">
            <label class="form-label">Kaedah Pembayaran</label>
            <select name="payment_method" class="form-select" required>
                <option value="" disabled <?= $payment_method === '' ? 'selected' : '' ?>>Sila pilih</option>
                <option value="Tunai" <?= $payment_method === 'Tunai' ? 'selected' : '' ?>>Tunai</option>
                <option value="Online Banking" <?= $payment_method === 'Online Banking' ? 'selected' : '' ?>>Online Banking</option>
                <option value="Kad Kredit/Debit" <?= $payment_method === 'Kad Kredit/Debit' ? 'selected' : '' ?>>Kad Kredit/Debit</option>
                <option value="E-wallet" <?= $payment_method === 'E-wallet' ? 'selected' : '' ?>>E-wallet</option>
            </select>
        </div>

        <h4 class="mt-4">Ringkasan Pesanan</h4>
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
                foreach ($order_items['kuantiti'] as $menu_id => $qty):
                    $menu_id = intval($menu_id);
                    $qty = intval($qty);
                    if ($qty <= 0) continue;
                    $res = $conn->query("SELECT nama, harga FROM menu WHERE id = $menu_id");
                    $menu = $res->fetch_assoc();
                    $subtotal = $menu['harga'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($menu['nama']) ?></td>
                    <td><?= $qty ?></td>
                    <td><?= number_format($menu['harga'], 2) ?></td>
                    <td><?= number_format($subtotal, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Jumlah Keseluruhan</th>
                    <th>RM <?= number_format($total, 2) ?></th>
                </tr>
            </tfoot>
        </table>

        <button type="submit" name="confirm_payment" class="btn btn-primary btn-lg">Sahkan & Bayar</button>
        <a href="order.php" class="btn btn-secondary btn-lg ms-2">Batal</a>
    </form>
</div>
</body>
</html>
