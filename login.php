<?php
session_start();
include 'koneksi.php';

// jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // cek user
    $result = $conn->query("SELECT * FROM user WHERE username='$username' LIMIT 1");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // login sukses
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Linda Salon</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://images.unsplash.com/photo-1601379324528-6f952873c0a1?auto=format&fit=crop&w=1400&q=80') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-container {
      background-color: rgba(11, 139, 245, 0.95);
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      width: 320px;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .login-container button {
      width: 100%;
      background-color: #333;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-size: 1em;
      cursor: pointer;
    }
    .login-container button:hover {
      background-color: #555;
    }
    .error {
      color: red;
      font-size: 0.9em;
      text-align: center;
      margin-bottom: 10px;
    }
    .back-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
    }
    .back-link a {
      color: #333;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login Linda Salon</h2>
    <?php if ($message): ?>
      <div class="error"><?= $message; ?></div>
    <?php endif; ?>
    <form action="" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div class="back-link">
      <a href="index.html">← Kembali ke Home</a>
    </div>
  </div>
</body>
</html>
