<?php
include '../db.php'; // 调整路径到你的 db.php

// Ambil semua pesanan
$sql = "SELECT o.id AS order_id, o.nama_pelanggan, o.phone, o.payment_method, o.created_at,
               m.nama AS menu_nama, oi.kuantiti, oi.remark, m.harga
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN menu m ON oi.menu_id = m.id
        ORDER BY o.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Sejarah Pesanan</title>
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
            padding: 30px;
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
        table th {
            background-color: #FFCCBC;
            color: #BF360C;
        }
        table td, table th {
            vertical-align: middle;
            text-align: center;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            background: #D84315;
            color: #fff;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .btn-back:hover {
            background: #BF360C;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📜 Sejarah Semua Pesanan</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Telefon</th>
                    <th>Kaedah Bayaran</th>
                    <th>Tarikh</th>
                    <th>Menu</th>
                    <th>Kuantiti</th>
                    <th>Harga (RM)</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['order_id'] ?></td>
                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['payment_method']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?= htmlspecialchars($row['menu_nama']) ?></td>
                        <td><?= $row['kuantiti'] ?></td>
                        <td><?= number_format($row['harga'], 2) ?></td>
                        <td><?= htmlspecialchars($row['remark']) ?: '-' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="../admin/dashboard.php" class="btn-back">⬅ Kembali ke Dashboard</a>
</div>
</body>
</html>
