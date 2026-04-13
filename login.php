<?php
session_start();
require_once 'include/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login Page</h2>

        <?php displayMessage(); ?>

        <p>This page is not finished yet. We will build it on Day 3.</p>
        <div class="link-text">
            <a href="register.php">Back to Register</a>
        </div>
    </div>
</body>
</html>