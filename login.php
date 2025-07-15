<?php
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "salon_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();
$message = "";

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = md5($_POST["password"]); // ⚠️ Gunakan bcrypt di produksi

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION["username"] = $username;
    header("Location: index.php");
    exit();
  } else {
    $message = "Username atau Password salah.";
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
      background-color: rgba(255, 255, 255, 0.95);
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
      <a href="index.php">← Kembali ke Home</a>
    </div>
  </div>
</body>
</html>
