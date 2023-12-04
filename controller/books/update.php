<?php



require_once __DIR__ . '/../../conf/connection.php';
require_once __DIR__ . '/../auth/middleware.php';
checkLogin();

function updateBook(PDO $pdo, $bookId, $updatedName) {
    try {
        
        $checkBookQuery = "SELECT * FROM books WHERE id = ?";
        $checkBookStmt = $pdo->prepare($checkBookQuery);
        $checkBookStmt->execute([$bookId]);
        $existingBook = $checkBookStmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingBook) {
            
            return false;
        }

        
        $updateBookQuery = "UPDATE books SET name = ? WHERE id = ?";
        $updateBookStmt = $pdo->prepare($updateBookQuery);

        
        $updateBookStmt->bindParam(1, $updatedName, PDO::PARAM_STR);
        $updateBookStmt->bindParam(2, $bookId, PDO::PARAM_INT);

        
        $updateBookStmt->execute();

        
        return true;
    } catch (PDOException $e) {
        
        die("Error updating book: " . $e->getMessage());
    }
}



?>
