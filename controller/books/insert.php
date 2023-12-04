<?php

// controller/books/insert.php

require_once __DIR__ . '/../../conf/connection.php';

require_once __DIR__ . '/../auth/middleware.php';
checkLogin();

function insertBook(PDO $pdo, $bookName) {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        // Handle the case where the user is not logged in
        return false;
    }

    $userId = $_SESSION["user_id"];

    try {
        // Sanitize input using prepared statements
        $insertBookQuery = "INSERT INTO books (name, user_id) VALUES (?, ?)";
        $insertBookStmt = $pdo->prepare($insertBookQuery);

        // Bind parameters to prepared statement
        $insertBookStmt->bindParam(1, $bookName, PDO::PARAM_STR);
        $insertBookStmt->bindParam(2, $userId, PDO::PARAM_INT);

        // Execute the prepared statement
        $insertBookStmt->execute();

        // Return true indicating successful insertion
        return true;
    } catch (PDOException $e) {
        // Handle the exception as needed (log, display an error message, etc.)
        die("Error inserting book: " . $e->getMessage());
    }
}

// You can add more functions here if needed

?>
