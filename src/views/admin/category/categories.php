<?php
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

require_once __DIR__ . '/../../../../config/functions/category.php';

// Ambil semua kategori dari database
$allCategories = getCategories($conn);
?>

<h2>Manage Categories</h2>

<!-- Tombol tambah kategori -->
<a href="index.php?page=add_category" class="btn btn-primary">Add Category</a>

<table class="table">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Actions</th>
    </tr>
    <?php if ($allCategories && $allCategories->num_rows > 0): ?>
        <?php $no = 1; ?>
        <?php while ($category = $allCategories->fetch_assoc()): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($category['name']); ?></td>
            <td><?= htmlspecialchars($category['slug']); ?></td>
            <td>
                <a href="index.php?page=edit_category&id=<?= $category['id']; ?>">Edit</a> |
                <a href="index.php?page=delete_category&id=<?= $category['id']; ?>" class="delete-link">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No categories found.</td>
        </tr>
    <?php endif; ?>
</table>
