<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/functions/user.php';

redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid request.');
}

$userId = intval($_GET['id']);
$user = getUserById($conn, $userId);

if (!$user) {
    die('User not found.');
}

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if (empty($username) || empty($email) || empty($role)) {
        $error = "All fields are required.";
    } else {
        $updateSuccess = updateUser($conn, $userId, $username, $email, $password, $role);
        if ($updateSuccess) {
            $success = "User updated successfully.";
            $user = getUserById($conn, $userId); // Refresh data
        } else {
            $error = "Failed to update user.";
        }
    }
}
?>

<h2>Edit User</h2>

<?php if ($success): ?>
    <p class="success"><?= $success; ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p class="error"><?= $error; ?></p>
<?php endif; ?>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>

    <label for="password">Password (leave blank to keep current password):</label>
    <input type="password" name="password" id="password">

    <label for="role">Role:</label>
    <select name="role" id="role" required>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="editor" <?= $user['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
        <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
    </select>

    <button type="submit">Update User</button>
</form>

<a href="index.php?page=users">Back to User List</a>
