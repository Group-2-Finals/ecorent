<?php
if (!isset($_COOKIE['userCredentials'])) {
    header("Location: login.php");
    exit();
} 
?>