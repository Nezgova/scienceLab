<?php
session_start();
require_once 'config.php'; // Database connection

class UserProfile {
    private $conn;
    private $user_id;
    private $user_data;
    public $specialties = [];
    public $user_articles = [];
    public $message = null;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->checkLogin();
        $this->fetchUserData();
        $this->fetchSpecialties();
        $this->fetchUserArticles(); // Fetch user's articles
        $this->handleFormSubmission();
    }

    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
        $this->user_id = $_SESSION['user_id'];
    }

    private function fetchUserData() {
        $stmt = $this->conn->prepare("
            SELECT username, email, profile_picture, description, sex, specialties, interests 
            FROM users WHERE id = ?
        ");
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $this->user_data = $stmt->get_result()->fetch_assoc();
    }

    private function fetchSpecialties() {
        $result = $this->conn->query("SELECT name FROM specialties");
        $this->specialties = $result->fetch_all(MYSQLI_ASSOC);
    }

    private function fetchUserArticles() {
        $stmt = $this->conn->prepare("SELECT title, link, created_at FROM articles WHERE author_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->user_articles = $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserData($key) {
        return $this->user_data[$key] ?? null;
    }

    private function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'] ?? '';
            $sex = $_POST['sex'] ?? '';
            $specialties = isset($_POST['specialties']) ? implode(',', $_POST['specialties']) : $this->getUserData('specialties');
            $interests = isset($_POST['interests']) ? implode(',', $_POST['interests']) : $this->getUserData('interests');
            $profile_picture = $this->getUserData('profile_picture');

            if (!empty($_FILES['profile_picture']['name'])) {
                $target_dir = "../attachments/";
                $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                    $profile_picture = "attachments/" . basename($_FILES['profile_picture']['name']);
                }
            }

            $stmt = $this->conn->prepare("
                UPDATE users SET profile_picture = ?, description = ?, sex = ?, specialties = ?, interests = ? WHERE id = ?
            ");
            $stmt->bind_param("sssssi", $profile_picture, $description, $sex, $specialties, $interests, $this->user_id);
            $stmt->execute();
            header("Location: profile.php");
            exit();
        }
    }
}

// Instantiate UserProfile class
$userProfile = new UserProfile($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../style/profile.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="profile.php" class="active">Profile</a></li>
        </ul>
        <a href="logout.php">
            <img src="../<?= htmlspecialchars($userProfile->getUserData('profile_picture') ?: 'attachments/default.png'); ?>" 
                 alt="Logout" class="profile-pic-navbar">
        </a>
    </nav>

    <!-- Profile Form -->
    <div class="profile-container">
        <h1>Welcome, <?= htmlspecialchars($userProfile->getUserData('username')); ?>!</h1>
        <img src="../<?= htmlspecialchars($userProfile->getUserData('profile_picture') ?: 'attachments/default_large.png'); ?>" 
             alt="Profile Picture" class="profile-pic-large">

        <form method="POST" enctype="multipart/form-data">
            <!-- Profile Picture -->
            <label for="profile_picture">Change Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <!-- Description -->
            <label for="description">Bio:</label>
            <textarea name="description" id="description" rows="5"><?= htmlspecialchars($userProfile->getUserData('description')); ?></textarea>

            <!-- Sex -->
            <label for="sex">Sex:</label>
            <select name="sex" id="sex">
                <option value="Male" <?= $userProfile->getUserData('sex') === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?= $userProfile->getUserData('sex') === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?= $userProfile->getUserData('sex') === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>

            <!-- Specialties -->
            <label for="specialties">Specialties:</label>
            <select name="specialties[]" id="specialties" multiple>
                <?php foreach ($userProfile->specialties as $specialty): ?>
                    <option value="<?= htmlspecialchars($specialty['name']); ?>" 
                        <?= in_array($specialty['name'], explode(',', $userProfile->getUserData('specialties'))) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($specialty['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Interests -->
            <label for="interests">Interests:</label>
            <select name="interests[]" id="interests" multiple>
                <?php
                $all_interests = ['AI Research', 'Data Science', 'Cybersecurity', 'Machine Learning', 'Software Engineering'];
                foreach ($all_interests as $interest): ?>
                    <option value="<?= htmlspecialchars($interest); ?>" 
                        <?= in_array($interest, explode(',', $userProfile->getUserData('interests'))) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($interest); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>

   <!-- Display User's Articles -->
<div class="user-articles">
    <h2>Your Articles</h2>
    <?php if (empty($userProfile->user_articles)): ?>
        <p>You haven't posted any articles yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($userProfile->user_articles as $article): ?>
                <li class="article-item">
                    <h3><a href="<?= htmlspecialchars($article['link']); ?>" target="_blank"><?= htmlspecialchars($article['title']); ?></a></h3>
                    <p>Posted on: <?= date('F j, Y', strtotime($article['created_at'])); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
