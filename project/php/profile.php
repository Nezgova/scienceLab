<?php
require 'db.php'; // Adjust this path if needed

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user profile data from the database
$stmt = $pdo->prepare("SELECT username, email, profile_picture, description, sex FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// For the logout hover tooltip
$username = $user['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile update
    $description = $_POST['description'];
    $sex = $_POST['sex'];
    $profile_picture = $user['profile_picture'];

    // Handle file upload if a new profile picture is provided
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../attachments/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
        $profile_picture = "attachments/" . basename($_FILES['profile_picture']['name']);
    }

    // Update user data in the database
    $update_stmt = $pdo->prepare("UPDATE users SET profile_picture = ?, description = ?, sex = ? WHERE id = ?");
    $update_stmt->execute([$profile_picture, $description, $sex, $user_id]);

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="../style/home.css"> <!-- Include shared navbar styles -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li class="profile-pic-container" title="Logout (<?= htmlspecialchars($username); ?>)">
                <a href="logout.php">
                    <img src="../<?= htmlspecialchars($user['profile_picture'] ?: 'attachments/default.png'); ?>" alt="Profile Picture" class="profile-pic">
                </a>
            </li>
        </ul>
    </nav>

    <div class="profile-container">
        <h1>Welcome, <?= htmlspecialchars($user['username']); ?>!</h1>

        <div class="profile-info">
            <img src="../<?= htmlspecialchars($user['profile_picture'] ?: 'attachments/default.png'); ?>" alt="Profile Picture" class="profile-pic">
            <form method="POST" enctype="multipart/form-data">
                <label for="profile_picture">Change Profile Picture:</label>
                <input type="file" name="profile_picture" id="profile_picture">

                <label for="description">Bio:</label>
                <textarea name="description" id="description" rows="5"><?= htmlspecialchars($user['description']); ?></textarea>

                <label for="sex">Sex:</label>
                <select name="sex" id="sex">
                    <option value="Male" <?= $user['sex'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?= $user['sex'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?= $user['sex'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>

                <button type="submit">Save Changes</button>
            </form>
        </div>

        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
