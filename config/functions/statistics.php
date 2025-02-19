<?php
include_once realpath(__DIR__ . '/../db.php'); // Pastikan koneksi database tersedia
// Fungsi untuk mendapatkan total kategori, proyek, dan pengguna
function getTotalStats($conn) {
    $stats = [
        'categories' => 0,
        'projects'   => 0,
        'users'      => 0
    ];

    $queries = [
        'categories' => "SELECT COUNT(*) FROM categories",
        'projects'   => "SELECT COUNT(*) FROM projects",
        'users'      => "SELECT COUNT(*) FROM users"
    ];

    foreach ($queries as $key => $sql) {
        $result = $conn->query($sql);
        if ($result) {
            $stats[$key] = $result->fetch_array()[0];
        }
    }

    return $stats;
}
?>
