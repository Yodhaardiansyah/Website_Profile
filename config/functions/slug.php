<?php
// Fungsi untuk membuat slug dari teks
function generateSlug($text) {
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text); // Hanya huruf, angka, spasi, dan strip
    $text = trim($text);
    $text = preg_replace('/\s+/', '-', $text); // Ganti spasi dengan strip
    $text = strtolower($text);
    return $text;
}

// Fungsi untuk mengecek apakah slug sudah ada dalam database
function slugExists($conn, $slug) {
    $stmt = $conn->prepare("SELECT id FROM projects WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}
?>
