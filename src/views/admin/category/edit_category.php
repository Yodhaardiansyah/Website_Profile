<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/functions/category.php';

redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

// Cek apakah ID dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid request.');
}

$categoryId = intval($_GET['id']);
$category = getCategoryById($conn, $categoryId); // Ambil data kategori

if (!$category) {
    die('Category not found.');
}

$success = $error = '';

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = strtolower(str_replace(' ', '-', $name)); // Buat slug otomatis

    if (empty($name)) {
        $error = "Category name cannot be empty.";
    } else {
        $updateSuccess = updateCategory($conn, $categoryId, $name, $slug);
        if ($updateSuccess) {
            $success = "Category updated successfully.";
            $category['name'] = $name;
            $category['slug'] = $slug;
        } else {
            $error = "Failed to update category. Slug might already exist.";
        }
    }
}
?>

<h2>Edit Category</h2>

<?php if ($success): ?>
    <p style="color: green;"><?= $success; ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color: red;"><?= $error; ?></p>
<?php endif; ?>

<form method="post">
    <label>Category Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name']); ?>" required>

    <button type="submit">Update Category</button>
</form>

<a href="index.php?page=categories">Back to Category List</a>
