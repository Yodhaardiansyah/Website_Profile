<?php
session_start();

// Cegah duplikasi fungsi
if (!function_exists('isAuthenticated')) {
    function isAuthenticated() {
        return isset($_SESSION['admin']);
    }
}

if (!function_exists('redirectIfNotAuthenticated')) {
    function redirectIfNotAuthenticated() {
        if (!isAuthenticated()) {
            header("Location: ../../public/admin/login.php");
            exit();
        }
    }
}
?>
