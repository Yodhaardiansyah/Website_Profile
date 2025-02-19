<?php
include_once realpath(__DIR__ . '/../../config/auth.php');  // Pastikan hanya admin yang bisa mengakses
include_once realpath(__DIR__ . '/../../src/views/admin/template/header.php'); // Load header

// Ambil parameter halaman, default ke 'dashboard'
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ?? 'dashboard';

// Daftar halaman yang diperbolehkan
$validPages = [
    'dashboard',

    // Halaman kategori
    'categories', 'add_category', 'edit_category', 'delete_category',

    // Halaman konten
    'content', 'add_content', 'edit_content', 'delete_content', 'delete_image',

    // Halaman user
    'users', 'add_user', 'edit_user', 'delete_user',

    // Halaman user
    'gallery_admin', 'upload_photo'
];

// Tentukan folder berdasarkan jenis halaman
$folderMap = [
    'users' => 'user',
    'add_user' => 'user',
    'edit_user' => 'user',
    'delete_user' => 'user',
    'categories' => 'category',
    'add_category' => 'category',
    'edit_category' => 'category',
    'delete_category' => 'category',
    'content' => 'content',
    'add_content' => 'content',
    'edit_content' => 'content',
    'delete_content' => 'content',
    'gallery_admin' => 'gallery',
    'upload_photo' => 'gallery'
];

$folder = $folderMap[$page] ?? '';
$pagePath = $folder 
    ? realpath(__DIR__ . "/../../src/views/admin/{$folder}/{$page}.php")
    : realpath(__DIR__ . "/../../src/views/admin/{$page}.php");

// Cek apakah halaman valid dan file benar-benar ada
if (in_array($page, $validPages) && $pagePath && file_exists($pagePath)) {
    include $pagePath;
} else {
    http_response_code(404);
    echo "<h2>404 - Page Not Found</h2>";
}

include_once realpath(__DIR__ . '/../../src/views/admin/template/footer.php'); // Load footer
?>
