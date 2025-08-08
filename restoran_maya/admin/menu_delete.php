<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 检查是否被订单引用
    $check = $conn->query("SELECT COUNT(*) AS total FROM order_items WHERE menu_id = $id");
    $data = $check->fetch_assoc();

    if ($data['total'] > 0) {
        // 被引用了，不能删
        echo "<script>
            alert('❌ 无法删除，该菜单已被订单使用。');
            window.location.href = 'menu_manage.php';
        </script>";
        exit();
    }

    // 如果没被引用，就安全删除
    $conn->query("DELETE FROM menu WHERE id = $id");

    echo "<script>
        alert('✅ 菜单已删除。');
        window.location.href = 'menu_manage.php';
    </script>";
    exit();
}
?>
