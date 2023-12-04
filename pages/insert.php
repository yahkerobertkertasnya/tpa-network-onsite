<?php
require_once '../conf/connection.php';
require_once '../controller/auth/middleware.php';
require_once '../controller/books/insert.php';

checkLogin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get book name from the form
    $bookName = $_POST['book_name'];

    // Insert the new book using the insertBook function
    $inserted = insertBook($pdo, $bookName);

    if ($inserted) {
        // Redirect back to main.php after the book is inserted
        header("Location: main.php");
        exit();
    } else {
        // Handle the case where the book couldn't be inserted
        echo "Error inserting the book.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Book</title>
</head>
<body>

<h1>Insert New Book</h1>

<form method="post" action="">
    <label for="book_name">Book Name:</label>
    <input type="text" name="book_name" required>

    <br>

    <input type="submit" value="Insert Book">
</form>

</body>
</html>
