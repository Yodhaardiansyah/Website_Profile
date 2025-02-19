<?php
include '../config/db.php'; // Pastikan koneksi menggunakan mysqli

// Ambil data kategori dari database
$query = $conn->query("SELECT name, slug FROM categories ORDER BY name ASC");

$categories = [];
while ($row = $query->fetch_assoc()) { // Gunakan fetch_assoc() untuk mysqli
    $categories[$row['name']] = $row['slug'];
}

// Sekarang $categories memiliki format yang sama seperti yang diinginkan
?>
