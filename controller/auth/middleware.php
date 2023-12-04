<?php
session_start();

function checkLogin() {
    
    if (!isset($_SESSION["username"])) {
        http_response_code(403);
        die('Forbidden');
        exit();
    }
}



?>
