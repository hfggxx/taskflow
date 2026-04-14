<?php
session_start();
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

if (isset($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = trim($_POST['password']);

    // 1. Basic validation
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    // 2. Check user in database
    if (empty($errors)) {
        $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                setMessage('success', 'Login successful.');
                redirect('dashboard.php');
            } else {
                $errors['password'] = "Incorrect password.";
            }
        } else {
            $errors['email'] = "No account found with this email.";
        }
    }
}
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
        <h2>Login</h2>

        <?php displayMessage(); ?>

        <form action="login.php" method="POST">
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

            <button type="submit">Login</button>
        </form>

        <div class="link-text">
            Don’t have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>