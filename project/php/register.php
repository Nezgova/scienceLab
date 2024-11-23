<?php
require 'db.php';  // Include the updated db.php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $username = explode('@', $email)[0];

    if (!str_ends_with($email, '@emsi.ma')) {
        $errors[] = "The email must end with '@emsi.ma'.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Use the $pdo object to interact with the database
        $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':email' => $email,
                ':username' => $username,
                ':password' => $hashed_password,
            ]);
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = $e->getCode() === '23000' ? "An account with this email already exists." : "An error occurred: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style><?php include '../style/login.css'; ?></style>
</head>
<body>
    <div class="login-box">
        <h2>Register</h2>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color: #ff4d4d;"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <div class="user-box">
                <input type="email" name="email" required>
                <label>Email (must end with @emsi.ma)</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <div class="user-box">
                <input type="password" name="confirm_password" required>
                <label>Confirm Password</label>
            </div>
            <a href="#" onclick="this.closest('form').submit(); return false;">
                <span></span>
                <span></span>
                <span></span>
                <span></span>Register
            </a>
        </form>
        <p style="color: white; text-align: center;">Already have an account? <a href="login.php" style="color: #fff;">Login here</a>.</p>
    </div>
</body>
</html>
