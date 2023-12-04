<?php
require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$host = $_ENV['MYSQL_HOST'];
$database = $_ENV['MYSQL_DATABASE'];
$username = $_ENV['MYSQL_ROOT_USER'];
$password = $_ENV['MYSQL_ROOT_PASSWORD'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the "users" table exists
    $checkTable = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($checkTable->rowCount() == 0) {
        // Create the "users" table if it doesn't exist
        $createTableQuery = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL
            )
        ";
        $pdo->exec($createTableQuery);
    }
    
    // Check if the "users" table exists
    $checkTable = $pdo->query("SHOW TABLES LIKE 'books'");
    if ($checkTable->rowCount() == 0) {
        // Create the "users" table if it doesn't exist
        $createTableQuery = "
            CREATE TABLE books (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                user_id INT NOT NULL
            )
        ";
        $pdo->exec($createTableQuery);
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
