<?php
include('../../conf/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    // Sanitize input using prepared statements
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$inputUsername]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $error = "Username already taken. Choose another.";
        header("Location: ../../pages/register.php?error=$error");
        exit();
    }

    // Insert new user with sanitized input
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

    // Bind parameters to prepared statement
    $stmt->bindParam(1, $inputUsername, PDO::PARAM_STR);
    $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);

    // Execute the prepared statement
    $stmt->execute();

    header("Location: ../../pages/login.php");
    exit();
}
?>
