<?php
require_once '../conf/connection.php';
require_once '../controller/auth/middleware.php';
require_once '../controller/books/get.php';
require_once '../controller/books/update.php';


checkLogin();


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    
    header("Location: ../main.php");
    exit();
}

$bookId = $_GET['id'];


$book = getBookById($pdo, $bookId);


if (!$book) {
    
    header("Location: main.php");
    exit();
}


if ($_SESSION['user_id'] !== $book['user_id']) {
    
    header("Location: main.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $updatedName = $_POST['name'];

    
    $updated = updateBook($pdo, $bookId, $updatedName);

    if ($updated) {
        
        header("Location: main.php");
        exit();
    } else {
        
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
