<?php
include_once __DIR__ . '/../db.php';

// Ambil semua pengguna
function getUsers($conn) {
    $query = "SELECT id, username, email, role FROM users ORDER BY id DESC";
    return $conn->query($query);
}

// Ambil user berdasarkan ID
function getUserById($conn, $id) {
    $stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Tambah user baru
function addUser($conn, $username, $email, $password, $role) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
    return $stmt->execute();
}

// Update user
function updateUser($conn, $id, $username, $email, $password, $role) {
    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $id);
    }
    return $stmt->execute();
}

// Hapus user
function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
