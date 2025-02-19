<nav class="sidebar">
    <h1>Admin Panel</h1>
    <ul>
        <li><a href="index.php?page=dashboard" class="<?= ($_GET['page'] === 'dashboard'  || empty($_GET['page'])) ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="index.php?page=content" class="<?= $_GET['page'] === 'content' ? 'active' : '' ?>">Manage Content</a></li>
        <li><a href="index.php?page=categories" class="<?= $_GET['page'] === 'categories' ? 'active' : '' ?>">Manage Categories</a></li>
        <li><a href="index.php?page=users" class="<?= $_GET['page'] === 'users' ? 'active' : '' ?>">Manage Users</a></li>
        <li><a href="../" class="btn-secondary">🔙 Back to Website</a></li> <!-- Tombol kembali -->
        <li><a href="logout.php" class="btn-danger">🚪 Logout</a></li> <!-- Logout dengan warna merah -->
    </ul>
</nav>



