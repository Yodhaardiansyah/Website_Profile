<?php
include_once realpath(__DIR__ . '/../../../../config/functions/content.php');
include_once realpath(__DIR__ . '/../../../../config/db.php');
redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo "ID konten tidak valid!";
    exit;
}

if (deleteContent($conn, $id)) {
    header("Location: index.php?page=content&status=deleted");
    exit;
} else {
    echo "Gagal menghapus konten.";
}
?>
