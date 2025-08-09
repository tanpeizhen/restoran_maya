<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['order_items'])) {
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];
    $total_amount = $_POST['total_amount'];

    // Masukkan ke jadual orders
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, payment_method, total_amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $customer_name, $phone, $payment_method, $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Masukkan item pesanan
    foreach ($_SESSION['order_items']['menu_id'] as $i => $menu_id) {
        $qty = $_SESSION['order_items']['quantity'][$i];
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, menu_id, quantity) VALUES (?, ?, ?)");
        $stmt_item->bind_param("iii", $order_id, $menu_id, $qty);
        $stmt_item->execute();
    }

    // Kosongkan sesi
    unset($_SESSION['order_items']);

    // Alih ke halaman kejayaan pesanan
    header("Location: order_success.php?id=" . $order_id);
    exit();
} else {
    header("Location: order.php");
    exit();
}
?>
