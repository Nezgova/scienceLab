<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID and username from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user profile picture
$stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$profile_picture = $user['profile_picture'] ?: 'attachments/default.png'; // Use a default image if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home.css"> <!-- Reuse home.css for consistent design -->
    <title>About - Submit Article</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php" class="active">About</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li class="logout">
                <a href="logout.php" class="profile-pic-container" title="Logout (<?= htmlspecialchars($username) ?>)">
                    <img src="../<?= htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic">
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Submit Your Article</h1>
        <p>Share your research with the community by submitting your article below.</p>
        
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="about.php">
            <div class="form-group">
                <label for="title">Article Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="link">Article Link</label>
                <input type="url" id="link" name="link" required>
            </div>
            <button type="submit" class="button">Submit Article</button>
        </form>
    </div>
</body>
</html>
