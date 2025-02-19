<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/functions/user.php';

redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid request.');
}

$userId = intval($_GET['id']);

$deleteSuccess = deleteUser($conn, $userId);

if ($deleteSuccess) {
    header('Location: index.php?page=users&status=deleted');
    exit;
} else {
    die('Failed to delete user.');
}
?>
