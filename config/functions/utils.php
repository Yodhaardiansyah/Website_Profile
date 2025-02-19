<?php
// Fungsi untuk membuat slug
function generateSlug($text) {
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
    $text = trim($text);
    $text = preg_replace('/\s+/', '-', $text);
    $text = preg_replace('/-+/', '-', $text); // Hilangkan strip ganda
    return strtolower($text);
}

// Cek apakah slug sudah ada
function slugExists($conn, $slug) {
    $stmt = $conn->prepare("SELECT id FROM projects WHERE slug = ? UNION SELECT id FROM categories WHERE slug = ?");
    $stmt->bind_param("ss", $slug, $slug);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}
?>
