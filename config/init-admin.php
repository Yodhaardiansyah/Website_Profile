<?php
// Konfigurasi database
include '/db.php';

// Fungsi untuk membersihkan input (untuk keamanan)
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
