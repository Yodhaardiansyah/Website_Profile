<?php
$host = "localhost";
$user = "root";  // Ganti sesuai MySQL kamu
$pass = "";       // Jika ada password, isi di sini
$dbname = "profile_yodha";

$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
