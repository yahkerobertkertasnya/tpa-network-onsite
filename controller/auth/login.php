<?php
session_start();

include('../../conf/connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$inputUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password'])) {
        $_SESSION["username"] = $inputUsername;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
        header("Location: ../view/login.php?error=$error");
        exit();
    }
}
?>
