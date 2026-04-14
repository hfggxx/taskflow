<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <a href="dashboard.php" class="logo">TaskFlow</a>
    </div>

    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="welcome-text">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<div class="page-wrapper">