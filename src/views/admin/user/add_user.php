<?php
require_once __DIR__ . '/../../../../config/db.php';
require_once __DIR__ . '/../../../../config/functions/user.php';

redirectIfNotAuthenticated(); // Pastikan hanya admin yang bisa mengakses

$success = $error = '';

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = trim($_POST['role']);

    if (empty($username) || empty($email) || empty($_POST['password']) || empty($role)) {
        $error = "All fields are required.";
    } else {
        $addSuccess = addUser($conn, $username, $email, $password, $role);
        if ($addSuccess) {
            header('Location: index.php?page=users&status=added');
            exit;
        } else {
            $error = "Failed to add user. Email might already exist.";
        }
    }
}
?>

<h2>Add User</h2>

<?php if ($error): ?>
    <p style="color: red;"><?= $error; ?></p>
<?php endif; ?>

<form method="post">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <label>Role:</label>
    <select name="role" required>
        <option value="admin">Admin</option>
        <option value="editor">Editor</option>
        <option value="user">User</option>
    </select>

    <button type="submit">Add User</button>
</form>

<a href="index.php?page=users">Back to User List</a>
