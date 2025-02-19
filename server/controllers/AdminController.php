<?php
include '../../config/db.php';

class AdminController {
    public static function deleteContent($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM content WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function deleteCategory($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function deleteUser($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
