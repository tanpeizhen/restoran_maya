<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_items = ['kuantiti' => []];
    foreach ($_POST['kuantiti'] as $menu_id => $qty) {
        $qty = intval($qty);
        if ($qty > 0) {
            $order_items['kuantiti'][$menu_id] = $qty;
        }
    }
    if (empty($order_items['kuantiti'])) {
        $error = "Sila pilih sekurang-kurangnya satu menu.";
    } else {
        $_SESSION['order_items'] = $order_items;
        header("Location: payment.php");
        exit;
    }
}

$result = $conn->query("SELECT * FROM menu ORDER BY kategori, nama");
$menu_by_category = [];
while ($row = $result->fetch_assoc()) {
    $menu_by_category[$row['kategori']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Pesanan Restoran</title>
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
        h3 {
            color: #E64A19;
            margin-bottom: 20px;
            border-bottom: 2px solid #FF7043;
            padding-bottom: 6px;
        }
        .menu-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(255, 112, 67, 0.4);
        }
        .card-body {
            padding: 20px;
            text-align: center;
        }
        .card-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: #BF360C;
        }
        .card-text {
            font-weight: 500;
            color: #FF5722;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        input.quantity-input {
            width: 80px;
            text-align: center;
            font-size: 1.1rem;
            border-radius: 12px;
            border: 2px solid #FF7043;
            transition: border-color 0.3s ease;
        }
        input.quantity-input:focus {
            border-color: #D84315;
            outline: none;
        }
        .btn-order {
            background: #D84315;
            border: none;
            color: #fff;
            font-size: 1.6rem;
            padding: 16px 50px;
            border-radius: 40px;
            box-shadow: 0 6px 15px rgba(216, 67, 21, 0.6);
            transition: background 0.3s ease;
            display: inline-block;
            margin: 30px auto 0 auto;
            cursor: pointer;
        }
        .btn-order:hover {
            background: #BF360C;
            box-shadow: 0 8px 20px rgba(191, 54, 12, 0.8);
        }
        .text-center {
            text-align: center;
        }
        .alert {
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Selamat Datang ke Restoran Kami</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <?php foreach ($menu_by_category as $kategori => $menus): ?>
            <h3>📂 <?= htmlspecialchars($kategori) ?></h3>
            <div class="row">
                <?php foreach ($menus as $menu): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="uploads/<?= htmlspecialchars($menu['imej']) ?>" alt="<?= htmlspecialchars($menu['nama']) ?>" class="menu-img" />
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($menu['nama']) ?></h5>
                                <p class="card-text">RM <?= number_format($menu['harga'], 2) ?></p>
                                <input type="number" name="kuantiti[<?= $menu['id'] ?>]" min="0" value="0" class="quantity-input" />
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <div class="text-center">
            <button type="submit" class="btn btn-order">Teruskan ke Pembayaran</button>
        </div>
    </form>
</div>
</body>
</html>
