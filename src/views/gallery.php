<?php
include __DIR__ . "/../../config/db.php"; // Koneksi database

$sql = "SELECT title, image_url, alt_text FROM gallery_images ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<main class="gallery-menu">
    <div class="gallery">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Pastikan path yang tersimpan di database bisa diakses dengan benar
                $imagePath = str_replace("public/", "../public/", $row["image_url"]);

                echo '<div class="gallery-item">';
                echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row["alt_text"]) . '">';
                echo '<p>' . htmlspecialchars($row["title"]) . '</p>';
                echo '</div>';
            }
        } else {
            echo "<p>Tidak ada gambar dalam galeri.</p>";
        }
        ?>
    </div>
</main>
