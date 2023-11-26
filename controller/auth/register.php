<?php
include('../../conf/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$inputUsername]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $error = "Username already taken. Choose another.";
        header("Location: ../view/register.php?error=$error");
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
    $stmt->execute([$inputUsername, $hashedPassword]);

    header("Location: ../view/login.php");
    exit();
}
?>
