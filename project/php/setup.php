<?php
$host = 'localhost'; // Database host
$dbname = 'lab_website'; // Database name
$user = 'root'; // Database username
$password = ''; // Database password

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database created successfully.<br>";

    // Connect to the newly created database
    $pdo->exec("USE $dbname");

    // Create the users table
    $tableSQL = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) UNIQUE NOT NULL,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('researcher', 'admin') DEFAULT 'researcher'
    )";

    $pdo->exec($tableSQL);
    echo "Users table created successfully.<br>";

    // Insert root admin account (if not exists)
    $rootEmail = 'root@emsi.ma';
    $rootUsername = 'root';
    $rootPassword = password_hash('root_password', PASSWORD_BCRYPT); // Change 'root_password' to your desired password

    $checkRootSQL = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($checkRootSQL);
    $stmt->execute([':email' => $rootEmail]);

    if ($stmt->rowCount() === 0) {
        $insertRootSQL = "
        INSERT INTO users (email, username, password, role) 
        VALUES (:email, :username, :password, 'admin')";
        $stmt = $pdo->prepare($insertRootSQL);
        $stmt->execute([
            ':email' => $rootEmail,
            ':username' => $rootUsername,
            ':password' => $rootPassword
        ]);
        echo "Root admin account created successfully.<br>";
    } else {
        echo "Root admin account already exists.<br>";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
