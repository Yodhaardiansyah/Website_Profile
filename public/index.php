<?php
// Load konfigurasi dasar
include __DIR__ . "/../config/db.php"; // Koneksi database
require_once __DIR__ . '/../config/init.php';
include __DIR__ . "/../src/views/template/sub-navbar.php";
include __DIR__ . "/../src/views/template/categories.php"; 

$category_pages = [];
// Simpan semua kategori ke dalam array
foreach ($categories as $title => $slug) {
    $category_pages[] = $slug; // Menyimpan slug ke array
}

// Tentukan halaman yang diminta dari URL (default ke home)
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Daftar halaman utama
$allowed_pages = ['home', 'about', 'portfolio', 'contact','gallery', 'detail'];


// Load Header
require_once __DIR__ . '/../src/views/template/header.php';

// Cek apakah halaman termasuk kategori portfolio
if (in_array($page, $category_pages)) {
    // Jika kategori, load template kategori
    require_once __DIR__ . '/../src/views/portfolio/category.php';
} elseif (in_array($page, $allowed_pages)) {
    // Jika halaman utama, load file dari /src/views/
    require_once __DIR__ . '/../src/views/' . $page . '.php';
} else {
    // Jika halaman tidak ditemukan, kembali ke home
    require_once __DIR__ . '/../src/views/home.php';
}
if ($page === 'detail' && isset($_GET['id'])) {
    require_once __DIR__ . '/../src/views/detail.php';
}

// Load Footer
require_once __DIR__ . '/../src/views/template/footer.php';


?>
