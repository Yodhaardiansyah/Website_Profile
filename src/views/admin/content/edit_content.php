<?php
include_once realpath(__DIR__ . '/../../../../config/functions/content.php');
include_once realpath(__DIR__ . '/../../../../config/db.php');
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses
// Ambil daftar kategori dari database
$categories = [];
$query = $conn->query("SELECT name, slug FROM categories ORDER BY name ASC");
while ($row = $query->fetch_assoc()) {
    $categories[] = $row;
}

// Ambil ID konten dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID konten tidak ditemukan!";
    exit;
}

// Ambil data konten berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$content = $stmt->get_result()->fetch_assoc();

if (!$content) {
    echo "Konten tidak ditemukan!";
    exit;
}

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $category_slug = $_POST['category'] ?? '';
    $content_text = $_POST['content'] ?? '';

    function createSlug($text) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    }
    $slug = createSlug($title);

    $description = $_POST['description'] ?? '';
    if (empty($description)) {
        $description = implode(' ', array_slice(explode(' ', $content_text), 0, 100));
    }

    $cover_image = $content['cover_image'];
    if (!empty($_FILES['cover_image']['name'])) {
        $uploadDir = realpath(__DIR__ . '/../../../../public/img/content/') . '/';
        $fileExt = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
        $fileName = $slug . "-cover." . $fileExt;
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetFilePath)) {
            $cover_image = $fileName;
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    }

    // Mengelola gambar tambahan dengan posisi
    $images = $content['images'] ? json_decode($content['images'], true) : [];

    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = realpath(__DIR__ . '/../../../../public/img/content/') . '/';
        foreach ($_FILES['images']['name'] as $key => $name) {
            $fileExt = pathinfo($name, PATHINFO_EXTENSION);
            $fileName = $slug . "-" . (count($images) + $key + 1) . "." . $fileExt;
            $targetFilePath = $uploadDir . $fileName;

            $position = $_POST['position'][$key] ?? 'top';

            if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFilePath)) {
                $images[] = [
                    'file' => $fileName,
                    'position' => $position
                ];
            }
        }
    }

    // Menghapus gambar jika dicentang untuk dihapus
    if (!empty($_POST['remove_images'])) {
        $removeImages = explode(',', $_POST['remove_images']);
        $images = array_filter($images, function ($image) use ($removeImages) {
            return !in_array($image['file'], $removeImages);
        });

        foreach ($removeImages as $file) {
            $filePath = realpath(__DIR__ . '/../../../../public/img/content/' . $file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Update posisi gambar yang sudah ada
    if (!empty($_POST['existing_images']) && !empty($_POST['existing_positions'])) {
        $existing_images = $_POST['existing_images'];
        $existing_positions = $_POST['existing_positions'];
        foreach ($images as &$image) {
            $index = array_search($image['file'], $existing_images);
            if ($index !== false) {
                $image['position'] = $existing_positions[$index];
            }
        }
    }

    $imagesJson = json_encode($images);

    if (updateContent($conn, $id, $title, $category_slug, $slug, $content_text, $description, $cover_image, $imagesJson)) {
        header("Location: index.php?page=content&status=success");
        exit;
    } else {
        echo "Gagal memperbarui konten.";
    }
}
?>

<h2>Edit Konten</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label for="title">Judul:</label><br>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($content['title']) ?>" required><br><br>

    <label for="category">Kategori:</label><br>
    <select name="category" id="category" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($categories as $cat) : ?>
            <option value="<?= htmlspecialchars($cat['slug']) ?>" <?= $cat['slug'] == $content['category'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="content">Konten:</label><br>
    <textarea name="content" id="content" rows="5" required><?= htmlspecialchars($content['content']) ?></textarea><br><br>

    <label for="cover_image">Cover Image:</label><br>
    <input type="file" name="cover_image" id="cover_image"><br><br>
    <img src="<?= '../img/content/' . $content['cover_image'] ?>" alt="Cover Image" width="100"><br><br>

    <label>Gambar Tambahan:</label><br>
    <div id="image-container">
        <button type="button" id="add-image">Tambah Foto</button><br><br>
    </div>

    <div id="existing_images">
        <?php if (!empty($content['images'])): ?>
            <?php $existing_images = json_decode($content['images'], true); ?>
            <?php foreach ($existing_images as $index => $image): ?>
                <div class="image-item">
                    <img src="<?= '../img/content/' . htmlspecialchars($image['file']) ?>" alt="Image <?= $index + 1 ?>" width="100">
                    <select name="existing_positions[]">
                        <option value="top" <?= $image['position'] == 'top' ? 'selected' : '' ?>>Atas</option>
                        <option value="middle" <?= $image['position'] == 'middle' ? 'selected' : '' ?>>Tengah</option>
                        <option value="bottom" <?= $image['position'] == 'bottom' ? 'selected' : '' ?>>Bawah</option>
                    </select>
                    <button type="button" onclick="removeImage('<?= htmlspecialchars($image['file']) ?>')">Hapus</button>
                    <input type="hidden" name="existing_images[]" value="<?= htmlspecialchars($image['file']) ?>">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <input type="hidden" name="remove_images" id="remove_images">
    <button type="submit">Simpan</button>
</form>

<script>
    document.getElementById('add-image').addEventListener('click', function() {
        let container = document.getElementById('image-container');
        let div = document.createElement('div');
        div.classList.add('image-input');
        div.innerHTML = `
            <input type="file" name="images[]" class="image-upload" required>
            <select name="position[]">
                <option value="top">Atas</option>
                <option value="middle">Tengah</option>
                <option value="bottom">Bawah</option>
            </select>
            <button type="button" class="remove-image">Hapus</button>
            <br>
        `;
        container.appendChild(div);

        div.querySelector('.remove-image').addEventListener('click', function() {
            div.remove();
        });
    });

    function removeImage(fileName) {
        let removeImages = document.getElementById('remove_images');
        let currentImages = removeImages.value ? removeImages.value.split(',') : [];
        if (!currentImages.includes(fileName)) {
            currentImages.push(fileName);
        }
        removeImages.value = currentImages.join(',');
        event.target.closest('div').remove();
    }
</script>
