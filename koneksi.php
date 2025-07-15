<?php
$host = "localhost";   
$user = "root";        
$pass = "";            
$db   = "salon_db";   

$conn = new mysqli($host, $user, $pass, $db);

// cek koneksi
if ($conn->connect_error) {
  die("Koneksi database gagal: " . $conn->connect_error);
}
?>
