<?php include __DIR__ . "/categories.php"; ?>

<?php
// Ambil halaman saat ini dari URL
$activePage = isset($_GET['page']) ? $_GET['page'] : '';

// Ambil semua kategori dari $categories
$categorySlugs = array_values($categories);

// Cek apakah halaman saat ini termasuk dalam kategori
$isCategoryPage = in_array($activePage, $categorySlugs);
?>

<!-- Submenu Kategori (Hanya Muncul di HP) -->
<nav class="sub-navbar">
    <div class="container">
        <!-- Tombol Toggle di HP -->
        <button class="subnav-toggle" onclick="toggleSubMenu()">☰ Categories</button>
        
        <ul id="subnav-list">
            <?php foreach ($categories as $title => $slug) : ?>
                <?php
                // Tambahkan class "active" jika menu sedang dipilih
                $activeClass = ($slug == $activePage || ($isCategoryPage && $slug == "portfolio")) ? 'class="active"' : '';
                ?>
                <li><a href="index.php?page=<?= $slug; ?>" <?= $activeClass; ?>><?= $title; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
