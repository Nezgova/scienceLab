<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize the database connection
$db = new Database();
$db->selectDatabase('lab_website');

// Get user ID and username from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user profile picture using the database object
$user = $db->fetchRow("SELECT profile_picture FROM users WHERE id = ?", [$user_id]);

// Handle case where user is not found or profile picture is missing
$profile_picture = $user ? ($user['profile_picture'] ?: 'attachments/default.png') : 'attachments/default.png';
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
                <a href="logout.php" class="profile-pic-container" title="Logout (<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>)">
                    <img src="../<?= htmlspecialchars($profile_picture, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture" class="profile-pic">
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
    </div>
</body>
</html>
