<?php
require 'db.php'; // Ensure the database connection file is included

// Fetch articles from the database
try {
    $stmt = $pdo->prepare("
        SELECT articles.id, articles.title, articles.link, articles.votes, articles.created_at, 
               users.username AS author
        FROM articles
        JOIN users ON articles.author_id = users.id
        ORDER BY articles.created_at DESC
    ");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching articles: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/articles.css">
    <title>Articles</title>
</head>
<body>
    <div class="container">
        <h1>Research Articles</h1>
        <div class="articles-list">
            <?php if (empty($articles)): ?>
                <p>No articles found. Be the first to post!</p>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <div class="article">
                        <h2><?= htmlspecialchars($article['title']) ?></h2>
                        <p>By: <?= htmlspecialchars($article['author']) ?></p>
                        <p>Published: <?= htmlspecialchars($article['created_at']) ?></p>
                        <a href="<?= htmlspecialchars($article['link']) ?>" target="_blank">Read Article</a>
                        <div class="votes">
                            <form action="vote.php" method="POST">
                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                <button type="submit" name="vote" value="up" class="upvote">👍 Upvote</button>
                                <span><?= $article['votes'] ?></span>
                                <button type="submit" name="vote" value="down" class="downvote">👎 Downvote</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
