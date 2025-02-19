<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/functions/category.php';

redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

// Cek apakah ID dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid request.');
}

$categoryId = intval($_GET['id']);

// Hapus kategori
$deleteSuccess = deleteCategory($conn, $categoryId);

if ($deleteSuccess) {
    header('Location: index.php?page=categories&status=deleted');
    exit;
} else {
    die('Failed to delete category.');
}
