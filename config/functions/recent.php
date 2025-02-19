<?php
include_once realpath(__DIR__ . '/../db.php'); // Pastikan koneksi database tersedia

// Fungsi untuk mengambil 5 proyek terbaru
function getRecentContents($conn) {
    $query = "SELECT c.id, c.title, c.slug, cat.name AS category, c.created_at 
              FROM projects c 
              LEFT JOIN categories cat ON c.category = cat.slug  -- Menggunakan slug untuk relasi
              ORDER BY c.created_at DESC 
              LIMIT 5";
    
    return $conn->query($query);
}
?>
