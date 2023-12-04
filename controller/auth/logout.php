<!-- controller/auth/logout.php -->

<?php
// Start the session to access session variables
session_start();

// Destroy the session and redirect to login page
session_destroy();

header("Location: ../../pages/login.php");
exit();
