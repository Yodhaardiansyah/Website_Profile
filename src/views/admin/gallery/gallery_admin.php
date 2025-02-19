<?php
include __DIR__ . "/../../../../config/db.php"; // Koneksi database

// Handle Hapus Foto
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Ambil path gambar dari database
    $sql_select = "SELECT image_url FROM gallery_images WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $delete_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        // Ubah path agar sesuai dengan lokasi file di server
        $file_path = __DIR__ . "/../../../../" . $row["image_url"];

        // Cek apakah file ada, lalu hapus
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Hapus data dari database
    $sql_delete = "DELETE FROM gallery_images WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();

    header("Location: index.php?page=gallery_admin");
    exit();
}

// Ambil semua data gambar
$sql = "SELECT id, title, image_url, alt_text FROM gallery_images ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>



<div class="admin-container">
    <h2>Kelola Galeri</h2>

    <!-- Form Upload -->
    <form action="index.php?page=upload_photo" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Judul Gambar" required>
        <input type="file" name="image" accept="image/*" required>
        <input type="text" name="alt_text" placeholder="Deskripsi Alt" required>
        <button type="submit">Upload Gambar</button>
    </form>

    <!-- Tabel Gambar -->
    <table class="gallery-table">
        <tr>
            <th>Preview</th>
            <th>Judul</th>
            <th>Deskripsi Alt</th>
            <th>Aksi</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="<?= str_replace("public/", "../", $row["image_url"]); ?>" 
                        alt="<?= htmlspecialchars($row["alt_text"]); ?>" width="100">
                     </td>

                    <td><?= htmlspecialchars($row["title"]); ?></td>
                    <td><?= htmlspecialchars($row["alt_text"]); ?></td>
                    <td>
                        <a href="index.php?page=gallery_admin&delete_id=<?= $row["id"]; ?>" onclick="return confirm('Hapus gambar ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Belum ada gambar.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

