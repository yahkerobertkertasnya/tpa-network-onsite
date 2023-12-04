<?php
session_start();

function checkLogin() {
    // Check if the user is logged in
    if (!isset($_SESSION["username"])) {
        http_response_code(403);
        die('Forbidden');
        exit();
    }
}

// You can add more middleware functions here if needed

?>
