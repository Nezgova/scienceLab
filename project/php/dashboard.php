<?php
require 'db.php'; // Adjust path if necessary
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data for greeting
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all articles
$articles_stmt = $pdo->prepare("SELECT id, title, link, votes, author_id FROM articles");
$articles_stmt->execute();
$articles = $articles_stmt->fetchAll(PDO::FETCH_ASSOC);

$username = $user['username']; // Set the username for use in the logout link
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li class="logout">
                <a href="logout.php">Logout (<?= htmlspecialchars($username); ?>)</a>
            </li>
        </ul>
    </nav>

    <main>
        <section class="welcome-section">
            <h2>Welcome, <?= htmlspecialchars($user['username']); ?>!</h2>
            <p>Here you can view and manage your articles, as well as see articles from others.</p>
        </section>

        <section class="articles-section">
            <h3>Other Articles</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></td>
                                <td><a href="<?= htmlspecialchars($article['link']); ?>" target="_blank">View Article</a></td>
                                <td><?= $article['votes']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No articles available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section class="actions-section">
            <a href="article.php" class="button">Vote</a>
        </section>
    </main>
</body>
</html>
