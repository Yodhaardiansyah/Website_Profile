
<div id="subnav-list" style="display: none;"></div>


<!-- Main Content -->
<main class="content">
    <div class="container">

        <!-- Welcome Section -->
        <section class="welcome">
            <h2>Hi, I'm Yodha Ardiansyah</h2>
            <img class="photo-home" src="../public/img/profile/yodha.jpg" alt="">
            <p>I have experience in various fields, including:</p>
            
        </section>

        <p class="blitz-text">
            <span class="category-container">
                <?php foreach ($categories as $title => $page): ?>
                    <a href="index.php?page=<?= $page ?>" class="category-link"><?= $title ?></a>
                    <?php if ($title !== array_key_last($categories)): ?>
                        |
                    <?php endif; ?>
                <?php endforeach; ?>
            </span>
        </p>
                

        <!-- Portfolio Button -->
        <section class="welcome">
            <a href="index.php?page=portfolio" class="btn">Watch My Portfolio</a>
        </section>

        <!-- Featured Projects -->
        <section class="featured-projects">
            <h2>My 3 Biggest Projects</h2>
            <div class="project-grid">
                <!-- Project 1 -->
                <div class="project">
                    <img src="<?php echo base_url('img/content/smart-basket.jpg'); ?>" alt="Smart Basket">
                    <div class="project-info">
                        <h3>Smart Basket with Computer Vision</h3>
                        <p>An automated cashier system using computer vision to detect shopping items.</p>
                        <a href="index.php?page=iot" class="btn">Read More</a>
                    </div>
                </div>

                <!-- Project 2 -->
                <div class="project">
                    <img src="<?php echo base_url('img/content/novel-3m.jpg'); ?>" alt="Novel">
                    <div class="project-info">
                        <h3>Novel: "3 Mil Mata Memandang"</h3>
                        <p>A collaborative novel about a teenager's journey to achieve his dreams.</p>
                        <a href="index.php?page=writing" class="btn">Read More</a>
                    </div>
                </div>

                <!-- Project 3 -->
                <div class="project">
                    <img src="<?php echo base_url('img/content/teater.jpg'); ?>" alt="Theater">
                    <div class="project-info">
                        <h3>Theater: "Bulan Segelap Mentari"</h3>
                        <p>A play written and directed by me, performed at Taman Budaya Yogyakarta.</p>
                        <a href="index.php?page=theater" class="btn">Read More</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Portfolio Categories Grid -->
        <section class="categories">
            <h2>Portfolio Categories</h2>
            <div class="category-grid">
                <?php foreach ($categories as $title => $page): ?>
                    <div class="category">
                        <h3><?= $title ?></h3>
                        <p>Explore more projects and achievements in this category.</p>
                        <a href="index.php?page=<?= $page ?>" class="btn">Explore</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</main>
