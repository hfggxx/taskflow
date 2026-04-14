<?php
require_once 'include/auth_check.php';
require_once 'include/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TaskFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome to TaskFlow</h2>

        <?php displayMessage(); ?>

        <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <p>You have successfully logged in.</p>

        <div class="link-text">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>