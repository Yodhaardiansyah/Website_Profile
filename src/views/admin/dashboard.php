<?php
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses
require_once __DIR__ . '/../../../config/functions/statistics.php';
require_once __DIR__ . '/../../../config/functions/recent.php';

// Ambil data statistik
$stats = getTotalStats($conn);

// Ambil 5 konten terbaru
$recentContents = getRecentContents($conn);
?>

<h2>Admin Dashboard</h2>

<div class="dashboard-container">
    <div class="dashboard-card">
        <h3><?= $stats['categories'] ?? '0'; ?></h3>
        <p>Total Categories</p>
    </div>
    <div class="dashboard-card">
        <h3><?= $stats['projects'] ?? '0'; ?></h3>
        <p>Total Contents</p>
    </div>
    <div class="dashboard-card">
        <h3><?= $stats['users'] ?? '0'; ?></h3>
        <p>Total Users</p>
    </div>
</div>

<h3>Recent Content</h3>
<table class="table">
    <tr>
        <th>No</th>
        <th>Title</th>
        <th>Category</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    <?php if ($recentContents && $recentContents->num_rows > 0): ?>
        <?php $no = 1; while ($content = $recentContents->fetch_assoc()): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($content['title']); ?></td>
            <td><?= htmlspecialchars($content['category'] ?? 'Uncategorized'); ?></td>
            <td><?= date("d M Y", strtotime($content['created_at'])); ?></td>
            <td>
                <a href="index.php?page=edit_content&id=<?= $content['id']; ?>">Edit</a> |
                <a href="index.php?page=delete_content&id=<?= $content['id']; ?>" 
                class="delete-link" 
                data-id="<?= $content['id']; ?>">
                    Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No recent content found.</td>
        </tr>
    <?php endif; ?>
</table>
