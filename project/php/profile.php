<?php
session_start();
require_once('config.php');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $sex = $_POST['sex'];
    $specialties = implode(',', $_POST['specialties'] ?? []); // Handle specialties
    $interests = implode(',', $_POST['interests'] ?? []); // Handle interests
    $profile_picture = $user['profile_picture'];

    // Handle file upload for profile picture
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../attachments/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
        $profile_picture = "attachments/" . basename($_FILES['profile_picture']['name']);
    }

    // Update user data
    $update_stmt = $conn->prepare("UPDATE users SET profile_picture = ?, description = ?, sex = ?, specialties = ?, interests = ? WHERE id = ?");
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
    <nav class="navbar">
        <div class="logo">Lab Portal</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
        <!-- Profile Picture as Logout Button -->
       <!-- Profile Picture in Navbar (Logout Button) -->
<a href="logout.php">
    <img src="../<?= htmlspecialchars($user['profile_picture'] ?: 'attachments/1.png'); ?>" alt="Logout" class="profile-pic-navbar">  </a>
    </nav>

    <div class="profile-container">
        <h1>Welcome, <?= htmlspecialchars($user['username']); ?>!</h1>

        <!-- Profile Picture in Profile Section -->
<img src="../<?= htmlspecialchars($user['profile_picture'] ?: 'attachments/2.png'); ?>" alt="Profile Picture" class="profile-pic-large">

            <form method="POST" enctype="multipart/form-data">
                <label for="profile_picture">Change Profile Picture:</label>
                <input type="file" name="profile_picture" id="profile_picture">

                <label for="description">Bio:</label>
                <textarea name="description" id="description" rows="5"><?= htmlspecialchars($user['description']); ?></textarea>

                <label for="sex">Sex:</label>
                <select name="sex" id="sex">
                    <option value="Male" <?= $user['sex'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?= $user['sex'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>

                <label for="specialties">Specialties:</label>
                <select name="specialties[]" id="specialties" multiple>
                    <option value="AI" <?= in_array('AI', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>AI</option>
                    <option value="Cybersecurity" <?= in_array('Cybersecurity', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Cybersecurity</option>
                    <option value="Data Science" <?= in_array('Data Science', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Data Science</option>
                    <option value="Machine Learning" <?= in_array('Machine Learning', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Machine Learning</option>
                    <option value="Blockchain" <?= in_array('Blockchain', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Blockchain</option>
                    <option value="Robotics" <?= in_array('Robotics', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Robotics</option>
                    <option value="Big Data" <?= in_array('Big Data', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Big Data</option>
                    <option value="Cloud Computing" <?= in_array('Cloud Computing', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Cloud Computing</option>
                    <option value="Internet of Things" <?= in_array('Internet of Things', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Internet of Things</option>
                    <option value="DevOps" <?= in_array('DevOps', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>DevOps</option>
                    <option value="Automation" <?= in_array('Automation', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Automation</option>
                    <option value="Virtualization" <?= in_array('Virtualization', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Virtualization</option>
                    <option value="Database Management" <?= in_array('Database Management', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Database Management</option>
                    <option value="Software Development" <?= in_array('Software Development', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Software Development</option>
                    <option value="Quantum Computing" <?= in_array('Quantum Computing', explode(',', $user['specialties'])) ? 'selected' : ''; ?>>Quantum Computing</option>
                </select>

                <label for="interests">Interests:</label>
                <select name="interests[]" id="interests" multiple>
                    <option value="AI" <?= in_array('AI', explode(',', $user['interests'])) ? 'selected' : ''; ?>>AI</option>
                    <option value="Cybersecurity" <?= in_array('Cybersecurity', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Cybersecurity</option>
                    <option value="Data Science" <?= in_array('Data Science', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Data Science</option>
                    <option value="Machine Learning" <?= in_array('Machine Learning', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Machine Learning</option>
                    <option value="Blockchain" <?= in_array('Blockchain', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Blockchain</option>
                    <option value="Robotics" <?= in_array('Robotics', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Robotics</option>
                    <option value="Game Development" <?= in_array('Game Development', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Game Development</option>
                    <option value="Cloud Computing" <?= in_array('Cloud Computing', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Cloud Computing</option>
                    <option value="Web Development" <?= in_array('Web Development', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Web Development</option>
                    <option value="Mobile App Development" <?= in_array('Mobile App Development', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Mobile App Development</option>
                    <option value="Entrepreneurship" <?= in_array('Entrepreneurship', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Entrepreneurship</option>
                    <option value="Blockchain" <?= in_array('Blockchain', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Blockchain</option>
                    <option value="Ethical Hacking" <?= in_array('Ethical Hacking', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Ethical Hacking</option>
                    <option value="Data Analytics" <?= in_array('Data Analytics', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Data Analytics</option>
                    <option value="Deep Learning" <?= in_array('Deep Learning', explode(',', $user['interests'])) ? 'selected' : ''; ?>>Deep Learning</option>
                </select>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
