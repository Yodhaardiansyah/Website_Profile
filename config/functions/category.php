<?php
include_once __DIR__ . '/../db.php';

// Ambil semua kategori
function getCategories($conn) {
    $query = "SELECT * FROM categories ORDER BY name ASC";
    return $conn->query($query);
}

// Ambil kategori berdasarkan ID
function getCategoryById($conn, $id) {
    $stmt = $conn->prepare("SELECT id, name, slug FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Tambah kategori baru
function addCategory($conn, $name, $slug) {
    $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $slug);
    return $stmt->execute();
}

// Update kategori
function updateCategory($conn, $id, $name, $slug) {
    $stmt = $conn->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $slug, $id);
    return $stmt->execute();
}

// Hapus kategori
function deleteCategory($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
