<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Linda Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .main-content {
      margin-left: 220px;
      padding: 20px;
    }
    .card-summary {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .card-summary .card {
      flex: 1 1 200px;
    }
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <h1>Dashboard</h1>
    <p>Halo, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>! Anda berhasil login.</p>

    <?php
    include 'koneksi.php';
    $produk_count = $conn->query("SELECT COUNT(*) as total FROM produk")->fetch_assoc()['total'];
    $booking_count = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
    $pending_count = $conn->query("SELECT COUNT(*) as total FROM bookings WHERE status='Pending'")->fetch_assoc()['total'];
    ?>

    <div class="card-summary">
      <div class="card bg-primary text-white">
        <div class="card-body">
          <h5 class="card-title">Total Produk</h5>
          <p class="card-text fs-4"><?= $produk_count ?></p>
        </div>
      </div>
      <div class="card bg-success text-white">
        <div class="card-body">
          <h5 class="card-title">Total Booking</h5>
          <p class="card-text fs-4"><?= $booking_count ?></p>
        </div>
      </div>
      <div class="card bg-warning text-dark">
        <div class="card-body">
          <h5 class="card-title">Booking Pending</h5>
          <p class="card-text fs-4"><?= $pending_count ?></p>
        </div>
      </div>
    </div>

    <h3>Booking Terbaru</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Produk</th>
          <th>User</th>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $booking = $conn->query("SELECT * FROM bookings ORDER BY id DESC LIMIT 5");
        while($b = $booking->fetch_assoc()):
        ?>
        <tr>
          <td><?= $b['id'] ?></td>
          <td><?= $b['produk'] ?></td>
          <td><?= $b['user'] ?></td>
          <td><?= $b['tanggal'] ?></td>
          <td><?= $b['waktu'] ?></td>
          <td><?= $b['status'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
