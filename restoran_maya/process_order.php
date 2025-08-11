<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $kuantiti = $_POST['kuantiti'] ?? [];

    if (empty($nama)) {
        echo "Sila isi nama pelanggan.";
        exit;
    }

    // 计算总价
    $total_amount = 0;
    foreach ($kuantiti as $menu_id => $qty) {
        $menu_id = intval($menu_id);
        $qty = intval($qty);
        if ($qty > 0) {
            $result = $conn->query("SELECT harga FROM menu WHERE id = $menu_id");
            if ($row = $result->fetch_assoc()) {
                $total_amount += $row['harga'] * $qty;
            }
        }
    }

    if ($total_amount <= 0) {
        echo "Sila pilih sekurang-kurangnya satu menu dengan kuantiti lebih dari 0.";
        exit;
    }

    // 插入 orders 表
    $stmt = $conn->prepare("INSERT INTO orders (nama_pelanggan, total_amount) VALUES (?, ?)");
    $stmt->bind_param("sd", $nama, $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // 插入 order_items 表
    $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, menu_id, kuantiti) VALUES (?, ?, ?)");
    foreach ($kuantiti as $menu_id => $qty) {
        $menu_id = intval($menu_id);
        $qty = intval($qty);
        if ($qty > 0) {
            $stmt2->bind_param("iii", $order_id, $menu_id, $qty);
            $stmt2->execute();
        }
    }

    $_SESSION['last_order_id'] = $order_id;
    header("Location: receipt.php");
    exit;
} else {
    echo "Akses tidak sah!";
}
