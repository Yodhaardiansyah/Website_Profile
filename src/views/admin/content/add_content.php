<?php
include_once realpath(__DIR__ . '/../../../../config/functions/content.php');
include_once realpath(__DIR__ . '/../../../../config/db.php'); // Pastikan koneksi database tersedia
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

// Ambil daftar kategori dari database
$categories = [];
$query = $conn->query("SELECT name, slug FROM categories ORDER BY name ASC");
while ($row = $query->fetch_assoc()) {
    $categories[] = $row;
}

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $category_slug = $_POST['category'] ?? ''; // Simpan slug kategori
    $content = $_POST['content'] ?? '';

    // Buat slug dari judul secara otomatis
    function createSlug($text) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    }
    $slug = createSlug($title);

    // Buat deskripsi otomatis jika kosong
    $description = $_POST['description'] ?? '';
    if (empty($description)) {
        $description = implode(' ', array_slice(explode(' ', $content), 0, 100)); // 100 kata pertama
    }

    // Upload cover image
    $cover_image = '';
    if (!empty($_FILES['cover_image']['name'])) {
        $uploadDir = realpath(__DIR__ . '/../../../../public/img/content/') . '/';
        $fileExt = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
        $fileName = $slug . "-cover." . $fileExt; // Format nama file baru
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetFilePath)) {
            $cover_image = $fileName;
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    }

    // Upload multiple images with position
    $images = [];
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = realpath(__DIR__ . '/../../../../public/img/content/') . '/';
        foreach ($_FILES['images']['name'] as $key => $name) {
            $fileExt = pathinfo($name, PATHINFO_EXTENSION);
            $fileName = $slug . "-" . ($key + 1) . "." . $fileExt; // Format nama file baru
            $targetFilePath = $uploadDir . $fileName;

            // Menangani posisi gambar yang dipilih
            $position = $_POST['position'][$key] ?? 'top'; // default position 'top'

            if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFilePath)) {
                // Simpan nama file dan posisi gambar
                $images[] = [
                    'file' => $fileName,
                    'position' => $position
                ];
            }
        }
    }

    // Simpan ke database
    if (addContent($conn, $title, $category_slug, $slug, $content, $description, $cover_image, json_encode($images))) {
        header("Location: index.php?page=content&status=success");
        exit;
    } else {
        echo "Gagal menambahkan konten.";
    }
}
?>

<h2>Tambah Konten</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label for="title">Judul:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="category">Kategori:</label><br>
    <select name="category" id="category" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($categories as $cat) : ?>
            <option value="<?= htmlspecialchars($cat['slug']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="content">Konten:</label><br>
    <textarea name="content" id="content" rows="5" required></textarea><br><br>

    <label for="description">Deskripsi:</label><br>
    <textarea name="description" id="description" rows="5"></textarea><br><br>

    <label for="cover_image">Cover Image:</label><br>
    <input type="file" name="cover_image" id="cover_image"><br><br>

    <label for="images">Gambar Tambahan (Opsional):</label><br>
    <input type="file" name="images[]" id="images" multiple><br><br>

    <!-- Posisi gambar per gambar -->
    <div id="image_positions">
        <label for="position[]">Posisi Gambar:</label><br>
        <!-- Posisi per gambar akan dimunculkan melalui JS nanti -->
    </div>

    <button type="button" id="addImageBtn">Tambah Gambar</button><br><br>

    <button type="submit">Simpan</button>
</form>

<script>
    document.getElementById('images').addEventListener('change', function(e) {
        let imagePositionsContainer = document.getElementById('image_positions');
        imagePositionsContainer.innerHTML = ''; // Clear previous positions

        let files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            let selectPosition = document.createElement('select');
            selectPosition.name = 'position[]';
            selectPosition.innerHTML = `
                <option value="top">Atas</option>
                <option value="middle">Tengah</option>
                <option value="bottom">Bawah</option>
            `;
            let label = document.createElement('label');
            label.innerText = 'Posisi Gambar ' + (i + 1) + ': ';
            imagePositionsContainer.appendChild(label);
            imagePositionsContainer.appendChild(selectPosition);
            imagePositionsContainer.appendChild(document.createElement('br'));
        }
    });

    document.getElementById('addImageBtn').addEventListener('click', function() {
        let imageInput = document.createElement('input');
        imageInput.type = 'file';
        imageInput.name = 'images[]';
        imageInput.id = 'images';
        imageInput.multiple = true;

        let imagePositionsContainer = document.getElementById('image_positions');
        imagePositionsContainer.appendChild(imageInput);
        imagePositionsContainer.appendChild(document.createElement('br'));

        // Tambahkan posisi untuk gambar tambahan
        let selectPosition = document.createElement('select');
        selectPosition.name = 'position[]';
        selectPosition.innerHTML = `
            <option value="top">Atas</option>
            <option value="middle">Tengah</option>
            <option value="bottom">Bawah</option>
        `;
        let label = document.createElement('label');
        label.innerText = 'Posisi Gambar Baru: ';
        imagePositionsContainer.appendChild(label);
        imagePositionsContainer.appendChild(selectPosition);
    });
</script>
