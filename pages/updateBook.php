<?php
require_once '../conf/connection.php';
require_once '../controller/auth/middleware.php';
require_once '../controller/books/get.php';
require_once '../controller/books/update.php';

// Check if the user is logged in
checkLogin();

// Check if a book ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to main.php if no valid book ID is provided
    header("Location: ../main.php");
    exit();
}

$bookId = $_GET['id'];

// Fetch the book details from the database using the new function
$book = getBookById($pdo, $bookId);

// Check if the book exists
if (!$book) {
    // Redirect to main.php if the book does not exist
    header("Location: main.php");
    exit();
}

// Check if the currently logged-in user is the owner of the book
if ($_SESSION['user_id'] !== $book['user_id']) {
    // Redirect to main.php if the user is not the owner
    header("Location: main.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated book data from the form
    $updatedName = $_POST['name'];

    // Update the book using the new function
    $updated = updateBook($pdo, $bookId, $updatedName);

    if ($updated) {
        // Redirect back to main.php after the book is updated
        header("Location: main.php");
        exit();
    } else {
        // Handle the case where the book with the given ID was not found
        echo "Book with ID $bookId not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
</head>
<body>

<h1>Update Book</h1>

<form method="post" action="">
    <label for="name">name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($book['name']) ?>" required>

    <input type="submit" value="Update Book">
</form>

</body>
</html>
