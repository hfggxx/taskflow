<?php
session_start();
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$username = '';
$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // 1. Basic validation
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    } elseif (strlen($username) < 3) {
        $errors['username'] = "Username must be at least 3 characters.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Please confirm your password.";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // 2. Check duplicate email
    if (empty($errors)) {
        $checkSql = "SELECT id FROM users WHERE email = ?";
        $stmt = $pdo->prepare($checkSql);
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors['email'] = "This email is already registered.";
        }
    }

    // 3. Insert user if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insertSql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($insertSql);

        if ($stmt->execute([$username, $email, $hashed_password])) {
            setMessage('success', 'Registration successful. Please log in.');
            redirect('login.php');
        } else {
            setMessage('error', 'Something went wrong. Please try again.');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TaskFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>

        <?php displayMessage(); ?>

        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
            <?php if (isset($errors['username'])): ?>
                <div class="error-text"><?php echo $errors['username']; ?></div>
            <?php endif; ?>

            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error-text"><?php echo $errors['email']; ?></div>
            <?php endif; ?>

            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <?php if (isset($errors['password'])): ?>
                <div class="error-text"><?php echo $errors['password']; ?></div>
            <?php endif; ?>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">
            <?php if (isset($errors['confirm_password'])): ?>
                <div class="error-text"><?php echo $errors['confirm_password']; ?></div>
            <?php endif; ?>

            <button type="submit">Register</button>
        </form>

        <div class="link-text">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>