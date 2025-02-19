<?php
include __DIR__ . "/../../config/db.php"; // Koneksi database

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mendapatkan detail proyek
$stmt = $conn->prepare("SELECT title, description, content, cover_image, images, category, created_at FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    echo "<div class='container mt-5'><h2>Project not found</h2></div>";
} else {
    $title = $project['title']; // Set title untuk header
?>

<!-- Load Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<main class="detail-project-container">
    <div class="card shadow-lg detail-project-card">
        <div class="card-body">
            <div class="detail-project-header">
                <h2><?php echo htmlspecialchars($project['title']); ?></h2>
            </div>
            <p class="detail-project-meta">Kategori: <?php echo htmlspecialchars($project['category']); ?> | 
                Tanggal: <?php echo date("d M Y", strtotime($project['created_at'])); ?></p>

            <!-- Cover Image -->
            <?php if (!empty($project['cover_image'])): ?>
                <img src="<?php echo base_url('img/content/' . htmlspecialchars($project['cover_image'])); ?>" 
                alt="<?php echo htmlspecialchars($project['title']); ?>" 
                class="detail-project-cover">
            <?php endif; ?>

            <!-- Images berdasarkan posisi -->
            <?php
            $images = json_decode($project['images'], true);
            if (!empty($images)) :
            ?>
                <!-- Gambar di Atas Deskripsi (Swiper) -->
                <div class="swiper-container detail-project-top-images">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $image) : ?>
                            <?php if ($image['position'] == 'top') : ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo base_url('img/content/' . htmlspecialchars($image['file'])); ?>" alt="Image">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <p class="detail-project-content"><?php echo nl2br(htmlspecialchars($project['content'])); ?></p>


            <!-- Gambar di Tengah (Lebih Kecil dan Berjejer) -->
            <?php if (!empty($images)) : ?>
                <div class="detail-project-images">
                    <?php foreach ($images as $image) : ?>
                        <?php if ($image['position'] == 'middle') : ?>
                            <img src="<?php echo base_url('img/content/' . htmlspecialchars($image['file'])); ?>" alt="Image">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <br>
            <br>
            <?php if (!empty($images)) : ?>
                <!-- Gambar di Bawah Deskripsi (Swiper) -->
                <div class="swiper-container detail-project-bottom-images">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $image) : ?>
                            <?php if ($image['position'] == 'bottom') : ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo base_url('img/content/' . htmlspecialchars($image['file'])); ?>" alt="Image">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Tombol Navigasi -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    <!-- Pagination (Opsional) -->
                    <div class="swiper-pagination"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Load Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiperTopImages = new Swiper(".detail-project-top-images", {
        slidesPerView: 3,  // Menyesuaikan ukuran gambar
        centeredSlides: true,
        spaceBetween: 10,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });

    var swiperBottomImages = new Swiper(".detail-project-bottom-images", {
        slidesPerView: 3, // Default: Menampilkan 3 gambar
        centeredSlides: true, // Gambar tengah lebih besar
        spaceBetween: 10, // Jarak antar gambar
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 5 // Di layar besar, tampil 5 gambar
            },
            480: {
                slidesPerView: 3 // Di layar kecil, tampil 3 gambar
            }
        }
    });

</script>

<?php

}
?>


