<?php
session_start();
require 'db.php';

class ArticlePortal {
    private $pdo;
    private $user_id;
    private $username;
    public $profile_picture;
    public $message = null;
    public $articles = [];

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->checkLogin();
        $this->fetchUserProfile();
        $this->handleArticleSubmission();
        $this->fetchArticles();
    }

    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
        $this->user_id = $_SESSION['user_id'];
        $this->username = $_SESSION['username'];
    }

    public function getUsername() {
        return $this->username;
    }

    private function fetchUserProfile() {
        $stmt = $this->pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
        $stmt->execute([$this->user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->profile_picture = $user['profile_picture'] ?? 'attachments/default.png';
    }

    private function handleArticleSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $link = trim($_POST['link']);

            if (!empty($title) && !empty($link)) {
                try {
                    $stmt = $this->pdo->prepare("
                        INSERT INTO articles (title, link, author_id, created_at) 
                        VALUES (:title, :link, :author_id, NOW())
                    ");
                    $stmt->execute([
                        ':title' => $title,
                        ':link' => $link,
                        ':author_id' => $this->user_id
                    ]);
                    $this->message = "Article submitted successfully!";
                } catch (Exception $e) {
                    $this->message = "Failed to submit article: " . $e->getMessage();
                }
            } else {
                $this->message = "Please fill in both the title and the link.";
            }
        }
    }

    private function fetchArticles() {
        $searchQuery = $_GET['search'] ?? '';
        $sql = "
            SELECT articles.id, articles.title, articles.link, articles.votes, articles.created_at, 
                   users.username AS author
            FROM articles
            JOIN users ON articles.author_id = users.id
        ";
        if ($searchQuery) {
            $sql .= " WHERE articles.title LIKE :searchQuery OR users.username LIKE :searchQuery";
        }
        $sql .= " ORDER BY articles.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        
        if ($searchQuery) {
            $stmt->execute([':searchQuery' => '%' . $searchQuery . '%']);
        } else {
            $stmt->execute();
        }
        $this->articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}


// Instantiate the ArticlePortal class
$portal = new ArticlePortal($pdo);
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
                <a href="logout.php" class="profile-pic-container" title="Logout (<?= htmlspecialchars($portal->getUsername()) ?>)">
                    <img src="../<?= htmlspecialchars($portal->profile_picture); ?>" alt="Profile Picture" class="profile-pic">
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
    <h1>Submit Your Article</h1>
    <p>Share your research with the community by submitting your article below.</p>
    
    <?php if ($portal->message): ?>
        <p class="message"><?= htmlspecialchars($portal->message) ?></p>
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

    <!-- Search form -->
    <form method="GET" action="about.php" class="search-form">
        <input type="text" name="search" placeholder="Search articles..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Search</button>
    </form>
</div>


    <!-- Dashboard Section (Articles) -->
    <div class="articles-section">
        <h2>Research Articles</h2>
        <?php if (empty($portal->articles)): ?>
            <p>No articles found. Be the first to post!</p>
        <?php else: ?>
            <div class="articles-list">
                <?php foreach ($portal->articles as $article): ?>
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
