<?php
session_start();
include '../../config/db.php'; // Koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Hapus spasi tidak sengaja
    $password = $_POST['password'];

    // Gunakan prepared statement
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc(); // Ambil hasil sebagai array asosiatif

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin'] = $user['username'];
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login-admin.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <button class="button-back"><a href="../">Kembali ke Website</a></button>
        </form>
    </div>
    
</body>
</html>
