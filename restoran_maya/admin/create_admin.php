<?php
// 连接数据库
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "restoran_maya";

$conn = new mysqli($host, $user, $pass, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 创建 admin 表（如果不存在）
$sql_create_table = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql_create_table) === TRUE) {
    echo "✅ admin 表已存在或已创建<br>";
} else {
    die("❌ 创建 admin 表失败: " . $conn->error);
}

// 检查是否已有 admin 用户
$sql_check = "SELECT * FROM admin WHERE username='admin'";
$result = $conn->query($sql_check);

if ($result->num_rows == 0) {
    // 插入 admin 账号，密码 123456
    $hashed_password = password_hash("123456", PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO admin (username, password) VALUES ('admin', '$hashed_password')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "✅ 已创建账号：admin / 123456<br>";
    } else {
        die("❌ 创建账号失败: " . $conn->error);
    }
} else {
    echo "⚠️ admin 用户已存在<br>";
}

$conn->close();
?>
