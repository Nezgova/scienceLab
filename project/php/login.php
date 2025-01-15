<?php
require 'db.php';  // Include the updated db.php to use the $pdo object

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    } else {
        // Use the $pdo object to query the users table
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and verify password
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: home.php');
            exit;
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style><?php include '../style/login.css'; ?></style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color: #ff4d4d;"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="user-box">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label>Password WAAAAAAAAAAAAAAAAA  </label>
            </div>
            <a href="#" onclick="this.closest('form').submit(); return false;">
                <span></span>
                <span></span>
                <span></span>
                <span></span>Login
            </a>
        </form>
        <p style="color: white; text-align: center;">Don't have an account? <a href="register.php" style="color: #fff;">Register here</a>.</p>
    </div>
</body>
</html>
