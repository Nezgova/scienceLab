<?php
require 'db.php'; // Include the database connection

$errors = []; // Array to hold error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Extract username from email
    $username = explode('@', $email)[0];

    // Validation: Check if email ends with @emsi.ma
    if (!str_ends_with($email, '@emsi.ma')) {
        $errors[] = "The email must end with '@emsi.ma'.";
    }

    // Validation: Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Validation: Ensure fields are not empty
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user into the database
        $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':email' => $email,
                ':username' => $username,
                ':password' => $hashed_password,
            ]);
            header('Location: login.php'); // Redirect to login page after successful registration
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // Duplicate entry error code
                $errors[] = "An account with this email already exists.";
            } else {
                $errors[] = "An error occurred: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styles.css">
    <title>Register</title>
</head>
<body>
    <div class="form-container">
        <h1>Register</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <input type="email" name="email" placeholder="Email (must end with @emsi.ma)" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
