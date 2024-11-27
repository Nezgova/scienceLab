<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "lab_website"; // Define your database name
    public $conn;

    // Constructor to establish the connection to the database
    public function __construct() {
        $this->connect();
    }

    // Method to establish the connection
    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Method to create a new database if not exists
    public function createDatabase($dbName) {
        $this->conn->exec("CREATE DATABASE IF NOT EXISTS $dbName");
    }

    // Method to select a database
    public function selectDatabase($dbName) {
        $this->conn->exec("USE $dbName");
    }

    // Method to create a table with a provided query
    public function createTable($query) {
        $this->conn->exec($query);
    }

    // Method to fetch a single row
    public function fetchRow($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to fetch all rows
    public function fetchAll($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to execute a query (for insert, update, delete)
    public function execute($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
    }
}

// Now the database connection is available through the $pdo variable
$database = new Database();
$pdo = $database->conn;  // Use this $pdo to perform queries
?>
