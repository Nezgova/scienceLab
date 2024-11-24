<?php
session_start();
require_once('config.php'); // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile data
$query = "SELECT username, email, profile_picture, description, sex, specialties, interests FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch available specialties
$specialties_result = $conn->query("SELECT name FROM specialties");
$specialties = $specialties_result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $sex = $_POST['sex'] ?? '';

    // Safely handle specialties and interests
    $specialties = isset($_POST['specialties']) && is_array($_POST['specialties']) 
        ? implode(',', $_POST['specialties']) 
        : $user['specialties'];

    $interests = isset($_POST['interests']) && is_array($_POST['interests']) 
        ? implode(',', $_POST['interests']) 
        : $user['interests'];
    
    $profile_picture = $user['profile_picture'];

    // Handle file upload for profile picture
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../attachments/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $profile_picture = "attachments/" . basename($_FILES['profile_picture']['name']);
        }
    }

    // Update user data
    $update_stmt = $conn->prepare("
        UPDATE users SET profile_picture = ?, description = ?, sex = ?, specialties = ?, interests = ? WHERE id = ?
    ");
    $update_stmt->bind_param("sssssi", $profile_picture, $description, $sex, $specialties, $interests, $user_id);
    $update_stmt->execute();

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
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <a href="logout.php">
            <img src="../<?= htmlspecialchars($user['profile_picture'] ?: 'attachments/default.png'); ?>" 
                 alt="Logout" class="profile-pic-navbar">
        </a>
    </nav>

    <!-- Profile Form -->
    <div class="profile-container">
        <h1>Welcome, <?= htmlspecialchars($user['username']); ?>!</h1>
        <img src="../<?= htmlspecialchars($user['profile_picture'] ?: 'attachments/default_large.png'); ?>" 
             alt="Profile Picture" class="profile-pic-large">

        <form method="POST" enctype="multipart/form-data">
            <!-- Profile Picture -->
            <label for="profile_picture">Change Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <!-- Description -->
            <label for="description">Bio:</label>
            <textarea name="description" id="description" rows="5"><?= htmlspecialchars($user['description']); ?></textarea>

            <!-- Sex -->
            <label for="sex">Sex:</label>
            <select name="sex" id="sex">
                <option value="Male" <?= $user['sex'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?= $user['sex'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?= $user['sex'] === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>

            <!-- Specialties -->
            <label for="specialties">Specialties:</label>
            <select name="specialties[]" id="specialties" multiple>
                <?php foreach ($specialties as $specialty): ?>
                    <option value="<?= htmlspecialchars($specialty['name']); ?>" 
                        <?= in_array($specialty['name'], explode(',', $user['specialties'])) ? 'selected' : ''; ?>>
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
                        <?= in_array($interest, explode(',', $user['interests'])) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($interest); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
