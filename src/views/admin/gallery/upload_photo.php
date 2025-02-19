<?php
include __DIR__ . "/../../../../config/db.php"; // Koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $alt_text = $_POST['alt_text'];

    // Pastikan folder target benar
    $target_dir = __DIR__ . "/../../../../public/img/gallery/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Buat folder jika belum ada
    }

    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name; // Path absolut untuk penyimpanan
    $image_url = "public/img/gallery/" . $file_name; // Path relatif untuk database

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Masukkan ke database
        $sql = "INSERT INTO gallery_images (title, image_url, alt_text) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $image_url, $alt_text);
        $stmt->execute();
    } else {
        die("Gagal mengunggah file.");
    }
}

header("Location: index.php?page=gallery_admin");
exit();
?>
