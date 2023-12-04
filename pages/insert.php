<?php
require_once '../conf/connection.php';
require_once '../controller/auth/middleware.php';
require_once '../controller/books/insert.php';

checkLogin();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $bookName = $_POST['book_name'];

    
    $inserted = insertBook($pdo, $bookName);

    if ($inserted) {
        
        header("Location: main.php");
        exit();
    } else {
        
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
