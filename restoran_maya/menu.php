<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Menu Restoran Maya</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Senarai Menu</h1>
  <a href="index.html">← Kembali</a>
  <div style="display: flex; flex-wrap: wrap;">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div style="border: 1px solid #ccc; padding: 10px; margin: 10px; width: 200px;">
        <img src="assets/<?php echo $row['imej']; ?>" width="100%" alt="">
        <h3><?php echo $row['nama']; ?></h3>
        <p><?php echo $row['keterangan']; ?></p>
        <strong>RM <?php echo number_format($row['harga'], 2); ?></strong>
      </div>
    <?php } ?>
  </div>
</body>
</html>
