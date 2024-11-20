<?php
$host = 'localhost';
$dbname = 'lab_website';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('researcher', 'admin') DEFAULT 'researcher',
            profile_picture VARCHAR(255),
            description TEXT,
            sex ENUM('Male', 'Female', 'Other'),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");
    echo "Users table created or already exists.<br>";

    // Create articles table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS articles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            author_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            link TEXT NOT NULL,
            votes INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
        );
    ");
    echo "Articles table created or already exists.<br>";

    // Optional: Create a votes table for advanced voting system
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS votes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            article_id INT NOT NULL,
            vote ENUM('up', 'down') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
        );
    ");
    echo "Votes table created or already exists.<br>";

} catch (PDOException $e) {
    die("Error creating tables: " . $e->getMessage());
}
?>
