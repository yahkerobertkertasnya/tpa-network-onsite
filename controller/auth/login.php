<?php
session_start();

include('../../conf/connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$inputUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password'])) {
        
        $_SESSION["user_id"] = $user['id'];

        $_SESSION["username"] = $inputUsername;
        header("Location: ../../pages/main.php");
        exit();
    } else {
        $error = "Invalid username or password";
        header("Location: ../../pages/login.php?error=$error");
        exit();
    }
}
?>
