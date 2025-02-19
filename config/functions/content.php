<?php
include_once __DIR__ . '/../db.php'; // Pastikan koneksi ke database
function getAllContents($conn) {
    $stmt = $conn->query("SELECT id, title, category, cover_image FROM projects ORDER BY created_at DESC");
    
    $result = [];
    while ($row = $stmt->fetch_assoc()) {
        $result[] = $row;
    }

    return $result;
}

function addContent($conn, $title, $category, $slug, $content, $description, $cover_image, $images) {
    $stmt = $conn->prepare("INSERT INTO projects (title, category, slug, content, description, cover_image, images, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $title, $category, $slug, $content, $description, $cover_image, $images);
    return $stmt->execute();
}

function updateContent($conn, $id, $title, $category_slug, $slug, $content_text, $description, $cover_image, $images) {
    // Persiapkan query untuk memperbarui konten tanpa updated_at
    $stmt = $conn->prepare("UPDATE projects SET title = ?, description = ?, content = ?, cover_image = ?, images = ?, category = ?, slug = ? WHERE id = ?");
    
    if ($stmt === false) {
        // Jika gagal menyiapkan statement
        echo "Error preparing statement: " . $conn->error;
        return false;
    }

    // Bind parameter ke query
    $stmt->bind_param("sssssssi", $title, $description, $content_text, $cover_image, $images, $category_slug, $slug, $id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, return true
        return true;
    } else {
        // Jika gagal, tampilkan error
        echo "Error executing query: " . $stmt->error;
        return false;
    }
}
function deleteContent($conn, $id) {
    // Ambil data konten sebelum dihapus
    $stmt = $conn->prepare("SELECT cover_image, images FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $content = $stmt->get_result()->fetch_assoc();

    if (!$content) {
        return false;
    }

    // Hapus cover image jika ada
    if (!empty($content['cover_image'])) {
        $coverPath = realpath(__DIR__ . '/../../public/img/content/' . $content['cover_image']);
        if (file_exists($coverPath)) {
            unlink($coverPath);
        }
    }

    // Hapus gambar tambahan jika ada
    if (!empty($content['images'])) {
        $images = json_decode($content['images'], true);
        foreach ($images as $image) {
            $imagePath = realpath(__DIR__ . '/../../public/img/content/' . $image['file']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }

    // Hapus konten dari database
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

?>
