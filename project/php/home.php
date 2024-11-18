<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Get username from session
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
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li class="logout">
                <a href="logout.php">Logout (<?= htmlspecialchars($username) ?>)</a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="image-container">
            <img src="../attatchments/img1.png" alt="Lab Image">
        </div>
        <h1>Welcome to the Lab Portal</h1>
        <p>This is your home page where you can browse and upload research articles.</p>
    </div>
</body>
</html>
