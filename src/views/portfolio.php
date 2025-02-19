<?php
include __DIR__ . "/../../config/db.php"; // Koneksi ke database

// Query untuk mengambil data proyek
$query = "SELECT id, title, description, cover_image FROM projects ORDER BY created_at DESC";
$result = $conn->query($query);

?>

<!-- Submenu Kategori -->
<nav class="sub-navbar-normal">
    <div class="container">
        <ul>
            <?php
            include __DIR__ . "../template/categories.php"; 

            foreach ($categories as $title => $slug) {
                echo '<li><a href="index.php?page=' . $slug . '">' . $title . '</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>

<div class="about-content">
    <button class="btn-porto" onclick="toggleSubMenu()"> All Categories</button>
</div>

<!-- Portfolio Content -->
<main class="content">
    <div class="container">
        <div class="content-portfo">
            <h2>My Portfolio</h2>
            <p>Explore my projects across various fields.</p>
        </div>
        
        <section class="project-list">
            <div class="project-grid">

                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="project">
                        <img src="<?php echo base_url('img/content/' . htmlspecialchars($row['cover_image'])); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="project-info">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p><?php echo implode(' ', array_slice(explode(' ', htmlspecialchars($row['description'])), 0, 10)) . '...'; ?></p>
                            <a href="index.php?page=detail&id=<?php echo $row['id']; ?>" class="btn">Read More</a>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
        </section>
    </div>
</main>
