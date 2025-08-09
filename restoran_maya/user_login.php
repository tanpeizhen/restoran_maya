<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // 直接登录，无需密码验证
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname'] ?? $user['username'];
        header("Location: order.php");
        exit();
    } else {
        $error = "Nama pengguna tidak wujud.";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8" />
  <title>Login Pengguna (Tanpa Kata Laluan)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4 text-center">🔓 Login Pengguna</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow bg-white">
      <div class="mb-3">
        <label class="form-label">Nama Pengguna</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <button type="submit" class="btn btn-success w-100">Masuk</button>
    </form>
  </div>
</body>
</html>
