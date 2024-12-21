<?php
$host = '127.0.0.1'; // Database host
$user = 'root';      // MySQL username
$pass = '';          // MySQL password
$dbName = 'lab_website'; // Database name

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to MySQL successfully.<br>";

    // Create the database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbName");
    echo "Database '$dbName' created successfully.<br>";

    // Use the database
    $pdo->exec("USE $dbName");
    echo "Using database '$dbName'.<br>";

    // Create 'users' table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            username VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'researcher') DEFAULT 'researcher',
            profile_picture VARCHAR(255) DEFAULT 'attachments/default.png',
            description TEXT,
            sex ENUM('male', 'female') DEFAULT NULL,
            specialties TEXT,
            interests TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Table 'users' created successfully.<br>";

    // Create 'articles' table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS articles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            author_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            link VARCHAR(255) NOT NULL,
            votes INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");
    echo "Table 'articles' created successfully.<br>";

    // Create 'user_votes' table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_votes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            article_id INT NOT NULL,
            vote ENUM('up', 'down') NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
        )
    ");
    echo "Table 'user_votes' created successfully.<br>";

    // Create 'specialties' table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS specialties (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL
        )
    ");
    echo "Table 'specialties' created successfully.<br>";

    // Insert root admin user
    $rootPassword = password_hash('rootpassword', PASSWORD_BCRYPT); // Replace 'rootpassword' with a secure password
    $pdo->exec("
        INSERT INTO users (email, username, password, role) 
        VALUES ('root@labportal.com', 'root', '$rootPassword', 'admin')
        ON DUPLICATE KEY UPDATE 
        email = VALUES(email),
        password = VALUES(password),
        role = VALUES(role)
    ");
    echo "Root admin user created successfully.<br>";

    echo "Setup completed successfully.";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
