<?php
$host = "localhost";
$user = "root"; // 默认XAMPP数据库用户
$pass = ""; // 默认XAMPP密码为空
$dbname = "restoran_maya";

// 创建连接
$conn = new mysqli($host, $user, $pass, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Sambungan ke pangkalan data gagal: " . $conn->connect_error);
}
?>
