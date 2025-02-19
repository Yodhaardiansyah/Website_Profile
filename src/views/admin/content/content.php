<?php
include_once realpath(__DIR__ . '/../../../../config/functions/content.php');
include_once realpath(__DIR__ . '/../../../../config/db.php');
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

// Ambil semua konten dari database
$contents = getAllContents($conn);
?>

<h2>Manajemen Konten</h2>
<a href="index.php?page=add_content">Tambah Konten</a>

<!-- Tampilkan status jika ada -->
<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'deleted'): ?>
        <p style="color: red;">Konten berhasil dihapus!</p>
    <?php elseif ($_GET['status'] === 'added'): ?>
        <p style="color: green;">Konten berhasil ditambahkan!</p>
    <?php elseif ($_GET['status'] === 'updated'): ?>
        <p style="color: blue;">Konten berhasil diperbarui!</p>
    <?php endif; ?>
<?php endif; ?>

<!-- Tabel Konten -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Cover</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; // Inisialisasi nomor urut
        foreach ($contents as $content) : ?>
            <tr>
                <td><?= $no++ ?></td> <!-- Menggunakan nomor urut -->
                <td><?= htmlspecialchars($content['title']) ?></td>
                <td><?= htmlspecialchars($content['category']) ?></td>
                <td>
                    <?php if (!empty($content['cover_image'])) : ?>
                        <img src="<?= '../img/content/' . htmlspecialchars(basename($content['cover_image'])) ?>" alt="Cover Image" width="100">
                    <?php else : ?>
                        Tidak ada gambar
                    <?php endif; ?>
                </td>
                <td>
                    <a href="index.php?page=edit_content&id=<?= htmlspecialchars($content['id']) ?>">Edit</a> |
                    <a href="index.php?page=delete_content&id=<?= htmlspecialchars($content['id']) ?>" 
                    onclick="return confirm('Apakah Anda yakin ingin menghapus konten ini?');" 
                    style="color: red;">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
