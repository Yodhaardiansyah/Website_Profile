<?php include __DIR__ . "/../../../config/init.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yodha Ardiansyah - Portfolio</title>
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./js/script.js" defer></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

</head>

<body class="<?php echo isset($_GET['id']) ? 'white-background' : 'detail'; ?>">

<!-- Header -->
<header class="header">
    <div class="container">
        <h1 class="dynamic-text"><a href="index.php?page=home">Yodha Ardiansyah</a></h1>

        <!-- Thank You Section -->
        <section class="welcome-atas">
            <p>Thank you for stopping by! I am someone who loves to learn many things and I am interested in doing various activities, especially in IT and writing.</p>
        </section>
    </div>
    
</header>

<!-- Navigation Menu -->
<nav class="navbar">
    <div class="container">
        <ul>
            <?php 
            $current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

            // Daftar halaman subkategori Portfolio
            $portfolio_pages = ["iot", "software", "writing", "theater", "organization", "business", "training", "events", "competitions"];

            // Jika halaman saat ini adalah salah satu subkategori, anggap portfolio aktif
            $isPortfolioActive = in_array($current_page, $portfolio_pages) || $current_page == "portfolio";
            ?>

            <li><a href="index.php?page=home" class="<?= ($current_page == 'home') ? 'active' : '' ?>">Home</a></li>
            <li><a href="index.php?page=about" class="<?= ($current_page == 'about') ? 'active' : '' ?>">About Me</a></li>
            <li><a href="index.php?page=portfolio" class="<?= $isPortfolioActive ? 'active' : '' ?>">Portfolio</a></li>
            <li><a href="index.php?page=gallery" class="<?= ($current_page == 'gallery') ? 'active' : '' ?>">Gallery</a></li>
            <li><a href="index.php?page=contact" class="<?= ($current_page == 'contact') ? 'active' : '' ?>">Contact</a></li>
        </ul>
    </div>
</nav>
