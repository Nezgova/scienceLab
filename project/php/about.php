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

// Fetch articles from the database
$stmt = $pdo->prepare("
    SELECT articles.id, articles.title, articles.link, articles.votes, articles.created_at, 
           users.username AS author
    FROM articles
    JOIN users ON articles.author_id = users.id
    ORDER BY articles.created_at DESC
");
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/about.css">
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

    <!-- Dashboard Section (Articles) -->
    <div class="articles-section">
        <h2>Research Articles</h2>
        <?php if (empty($articles)): ?>
            <p>No articles found. Be the first to post!</p>
        <?php else: ?>
            <div class="articles-list">
                <?php foreach ($articles as $article): ?>
                    <div class="article" data-article-id="<?= $article['id'] ?>">
                        <h3><?= htmlspecialchars($article['title']) ?></h3>
                        <p>By: <?= htmlspecialchars($article['author']) ?></p>
                        <p>Published: <?= htmlspecialchars($article['created_at']) ?></p>
                        <a href="<?= htmlspecialchars($article['link']) ?>" target="_blank">Read Article</a>
                        <div class="votes">
                            <button class="vote-btn upvote" data-vote-action="up" data-article-id="<?= $article['id'] ?>">👍 Upvote</button>
                            <span class="vote-count"><?= $article['votes'] ?></span>
                            <button class="vote-btn downvote" data-vote-action="down" data-article-id="<?= $article['id'] ?>">👎 Downvote</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="../scripts/voting.js"></script>
</body>
</html>
