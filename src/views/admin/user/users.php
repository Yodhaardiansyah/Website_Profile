<?php
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses
require_once __DIR__ . '/../../../../config/functions/user.php';

// Ambil semua user dari database
$allUsers = getUsers($conn);
?>

<h2>Manage Users</h2>

<!-- Tombol tambah user -->
<a href="index.php?page=add_user" class="btn btn-primary">Add User</a>

<table class="table">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Email</th> <!-- Tambahkan kolom Email -->
        <th>Role</th>  <!-- Tambahkan kolom Role -->
        <th>Actions</th>
    </tr>
    <?php if ($allUsers && $allUsers->num_rows > 0): ?>
        <?php $no = 1; ?>
        <?php while ($user = $allUsers->fetch_assoc()): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($user['username']); ?></td>
            <td><?= htmlspecialchars($user['email'] ?? 'No Email'); ?></td> <!-- Tampilkan Email -->
            <td><?= htmlspecialchars($user['role'] ?? 'User'); ?></td> <!-- Tampilkan Role -->
            <td>
                <a href="index.php?page=edit_user&id=<?= htmlspecialchars($user['id']); ?>">Edit</a> |
                <a href="index.php?page=delete_user&id=<?= htmlspecialchars($user['id']); ?>" class="delete-link" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');" style="color: red;">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No users found.</td>
        </tr>
    <?php endif; ?>
</table>
