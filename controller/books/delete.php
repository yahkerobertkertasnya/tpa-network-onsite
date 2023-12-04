<?php
require_once __DIR__ . '/../../conf/connection.php';

require_once __DIR__ . '/../auth/middleware.php';
checkLogin();

function deleteBook(PDO $pdo, $bookId) {
    try {
        // Check if the book with the given ID exists
        $checkBookQuery = "SELECT * FROM books WHERE id = ?";
        $checkBookStmt = $pdo->prepare($checkBookQuery);
        $checkBookStmt->execute([$bookId]);
        $existingBook = $checkBookStmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingBook) {
            // Book with the given ID not found
            return false;
        }

        // Delete the book
        $deleteBookQuery = "DELETE FROM books WHERE id = ?";
        $deleteBookStmt = $pdo->prepare($deleteBookQuery);
        $deleteBookStmt->execute([$bookId]);

        // Return true indicating successful deletion
        return true;
    } catch (PDOException $e) {
        // Handle the exception as needed (log, display an error message, etc.)
        die("Error deleting book: " . $e->getMessage());
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $bookId = $_POST['id'];
        $deleted = deleteBook($pdo, $bookId);
        if ($deleted) {
            // Redirect back to main.php after the book is deleted
            header("Location: ../../pages/main.php");
            exit();
        } else {
            echo "Book with ID $bookId not found.";
        }
    }
}
?>
