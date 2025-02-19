<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/functions/category.php';

redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $slug = strtolower(str_replace(' ', '-', $name)); // Buat slug otomatis dari nama

    if (empty($name)) {
        $error = "Category name cannot be empty.";
    } else {
        $addSuccess = addCategory($conn, $name, $slug);
        if ($addSuccess) {
            $success = "Category added successfully.";
        } else {
            $error = "Failed to add category. Slug might already exist.";
        }
    }
}
?>

<h2>Add Category</h2>

<?php if ($success): ?>
    <p style="color: green;"><?= $success; ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color: red;"><?= $error; ?></p>
<?php endif; ?>

<form method="post">
    <label>Category Name:</label>
    <input type="text" name="name" required>

    <button type="submit">Add Category</button>
</form>

<a href="index.php?page=categories">Back to Category List</a>
