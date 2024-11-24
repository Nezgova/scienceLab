<?php
// Database configuration
$host = 'localhost';
$dbname = 'lab_website';
$username = 'root';
$password = '';

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Create specialties table
$create_specialties_table_query = "
CREATE TABLE IF NOT EXISTS specialties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)";
$pdo->exec($create_specialties_table_query);

// Create users table
$create_users_table_query = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    sex VARCHAR(10),
    specialties TEXT DEFAULT NULL,
    interests TEXT DEFAULT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL
)";
$pdo->exec($create_users_table_query);

// Insert sample specialties if empty
$check_specialties_query = $pdo->query("SELECT COUNT(*) FROM specialties");
if ($check_specialties_query->fetchColumn() == 0) {
    $insert_specialties_query = "
    INSERT INTO specialties (name) VALUES
    ('AI Research'),
    ('Data Science'),
    ('Cybersecurity'),
    ('Machine Learning'),
    ('Software Engineering')";
    $pdo->exec($insert_specialties_query);
}
?>
