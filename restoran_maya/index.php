<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Restoran Maya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f9d423, #ff4e50);
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: rgba(0,0,0,0.6);
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .hero {
            text-align: center;
            color: white;
            padding: 100px 20px;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }
        .menu-section {
            padding: 50px 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .footer {
            background-color: rgba(0,0,0,0.6);
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Restoran Maya</a>
        <div class="d-flex">
            <a href="admin/login.php" class="btn btn-outline-light">Login Admin</a>
        </div>
    </div>
</nav>

<div class="hero">
    <h1>Selamat Datang ke Restoran Maya</h1>
    <p>Nikmati hidangan terbaik kami secara dalam talian</p>
    <a href="order.php" class="btn btn-primary btn-lg">Pesan Sekarang</a>
</div>

<div class="container menu-section">
    <h2 class="text-center mb-5">Menu Kami</h2>
    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM menu ORDER BY kategori, id DESC");
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="uploads/'.$row['imej'].'" class="card-img-top" alt="'.$row['nama'].'">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$row['nama'].'</h5>';
            echo '<p class="card-text">'.$row['keterangan'].'</p>';
            echo '<p class="fw-bold">RM '.$row['harga'].'</p>';
            echo '</div></div></div>';
        }
        ?>
    </div>
</div>

<div class="footer">
    &copy; <?php echo date('Y'); ?> Restoran Maya. Semua Hak Cipta Terpelihara.
</div>

</body>
</html>