<?php
include __DIR__ . "/../../../config/db.php"; // Koneksi database
include __DIR__ . "../../template/categories.php"; 

// Tentukan kategori berdasarkan halaman yang sedang dimuat
$category = isset($_GET['page']) ? $_GET['page'] : 'iot';

// Pastikan kategori yang diminta ada dalam daftar, jika tidak default ke "iot"
if (!in_array($category, $categories)) {
    $category = "iot";
}

// Query untuk mengambil data proyek berdasarkan kategori
$stmt = $conn->prepare("SELECT id, title, description, cover_image FROM projects WHERE category = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Submenu Kategori -->
<nav class="sub-navbar-normal">
    <div class="container">
        <ul>
            <?php
            foreach ($categories as $title => $slug) {
                $active = ($slug == $category) ? 'class="active"' : '';
                echo '<li><a href="index.php?page=' . $slug . '" ' . $active . '>' . $title . '</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>

<!-- Konten Kategori -->
<main class="content">
    <div class="container">

    <div class="content-portfo">
        <h2><?php echo array_search($category, $categories); ?> Projects</h2>
        <p>Explore my projects in <?php echo array_search($category, $categories); ?>.</p>

    </div>
        
        <section class="project-list">
            <div class="project-grid">
                <?php if ($result->num_rows == 0) : ?>
                    <p>No projects available in this category.</p>
                <?php else : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="project">
                            <img src="<?php echo base_url('img/content/' . $row['cover_image']); ?>" alt="<?php echo $row['title']; ?>">
                            <div class="project-info">
                                <h3><?php echo $row['title']; ?></h3>
                                <p><?php echo $row['description']; ?></p>
                                <a href="index.php?page=detail&id=<?php echo $row['id']; ?>" class="btn">Read More</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
