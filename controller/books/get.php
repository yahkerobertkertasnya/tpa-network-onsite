<?php

require_once __DIR__ . '/../../conf/connection.php';

require_once __DIR__ . '/../auth/middleware.php';
checkLogin();


function getAllBooks(PDO $pdo) {
    try {
        $query = "SELECT * FROM books";
        $statement = $pdo->prepare($query);
        $statement->execute();

        
        $books = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $books;
    } catch (PDOException $e) {
        
        die("Error fetching books: " . $e->getMessage());
    }
}

function getBookById(PDO $pdo, $bookId) {
  try {
      $query = "SELECT * FROM books WHERE id = ?";
      $statement = $pdo->prepare($query);
      $statement->execute([$bookId]);

      return $statement->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      
      die("Error getting book by ID: " . $e->getMessage());
  }
}

?>
