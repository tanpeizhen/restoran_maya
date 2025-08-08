<form method="POST" action="menu_add.php" enctype="multipart/form-data">
  <div class="mb-3">
    <label>Nama Menu</label>
    <input type="text" name="nama" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Harga</label>
    <input type="number" step="0.01" name="harga" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Kategori</label>
    <input type="text" name="kategori" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Imej</label>
    <input type="file" name="imej" class="form-control">
  </div>

  <button type="submit" class="btn btn-success">Tambah Menu</button>
</form>
