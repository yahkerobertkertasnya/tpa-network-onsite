<?php

// controller/books/update.php

require_once __DIR__ . '/../../conf/connection.php';
require_once __DIR__ . '/../auth/middleware.php';
checkLogin();

function updateBook(PDO $pdo, $bookId, $updatedName) {
    try {
        // Sanitize input using prepared statements
        $checkBookQuery = "SELECT * FROM books WHERE id = ?";
        $checkBookStmt = $pdo->prepare($checkBookQuery);
        $checkBookStmt->execute([$bookId]);
        $existingBook = $checkBookStmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingBook) {
            // Book with the given ID not found
            return false;
        }

        // Update the book
        $updateBookQuery = "UPDATE books SET name = ? WHERE id = ?";
        $updateBookStmt = $pdo->prepare($updateBookQuery);

        // Bind parameters to prepared statement
        $updateBookStmt->bindParam(1, $updatedName, PDO::PARAM_STR);
        $updateBookStmt->bindParam(2, $bookId, PDO::PARAM_INT);

        // Execute the prepared statement
        $updateBookStmt->execute();

        // Return true indicating successful update
        return true;
    } catch (PDOException $e) {
        // Handle the exception as needed (log, display an error message, etc.)
        die("Error updating book: " . $e->getMessage());
    }
}

// You can add more functions here if needed

?>
