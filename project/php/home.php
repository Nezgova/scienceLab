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
$profile_picture = $user['profile_picture'] ?: 'attachments/default.png';

// Fetch top 3 voted articles
$top_articles_stmt = $pdo->query("
    SELECT title, link, votes 
    FROM articles 
    ORDER BY votes DESC 
    LIMIT 3
");
$top_articles = $top_articles_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home.css">
    <title>Home</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
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
        <div class="image-container">
            <img src="../attachments/img1.png" alt="Lab Image">
        </div>
        <h1>Welcome to the Lab Portal</h1>
        <p>This is your home page where you can browse and upload research articles.</p>

        <!-- Scoreboard for Top Articles -->
        <h2>Top Voted Articles</h2>
        <div class="scoreboard">
            <?php if (empty($top_articles)): ?>
                <p>No top articles available yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($top_articles as $article): ?>
                        <li>
                            <a href="<?= htmlspecialchars($article['link']) ?>" target="_blank">
                                <?= htmlspecialchars($article['title']) ?>
                            </a> - Votes: <?= htmlspecialchars($article['votes']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
