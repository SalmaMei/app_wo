<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

// Proses tambah paket
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $harga = floatval($_POST['harga']);
    $deskripsi = trim($_POST['deskripsi']);

    // Upload gambar
    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $target_dir = "uploads/";
        $filename = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $target_file;
        }
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO paket_wedding (nama, harga, deskripsi, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $nama, $harga, $deskripsi, $gambar);
    $stmt->execute();

    header("Location: data_paket.php");
    exit;
}

// Proses hapus paket
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM paket_wedding WHERE id=$id");
    header("Location: data_paket.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Paket Pernikahan - Linda Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }
    .img-thumbnail {
      max-width: 80px;
      max-height: 80px;
    }
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <h1>Data Paket Pernikahan</h1>

    <!-- Form tambah paket -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">Tambah Paket Wedding</div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label>Nama Paket</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label>Gambar Paket</label>
            <input type="file" name="gambar" class="form-control">
          </div>
          <button type="submit" class="btn btn-success">Simpan Paket</button>
        </form>
      </div>
    </div>

    <!-- Tabel data paket -->
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nama Paket</th>
          <th>Harga</th>
          <th>Deskripsi</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM paket_wedding");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
          <td><?= htmlspecialchars($row['deskripsi']) ?></td>
          <td>
            <?php if (!empty($row['gambar'])): ?>
              <img src="<?= htmlspecialchars($row['gambar']) ?>" class="img-thumbnail" alt="Gambar">
            <?php else: ?>
              <span class="text-muted">-</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="data_paket.php?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus paket ini?');">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
