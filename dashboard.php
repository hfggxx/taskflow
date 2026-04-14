<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$user_id = $_SESSION['user_id'];

// Total Projects
$stmt = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_projects = $stmt->fetchColumn();

// Total Tasks
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_tasks = $stmt->fetchColumn();

// Pending Tasks
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$user_id]);
$pending_tasks = $stmt->fetchColumn();

// Completed Tasks
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = ? AND status = 'completed'");
$stmt->execute([$user_id]);
$completed_tasks = $stmt->fetchColumn();

include 'include/header.php';
?>

<div class="container dashboard-container">
    <h2>Dashboard</h2>

    <?php displayMessage(); ?>

    <p class="dashboard-intro">
        Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.
        Here is a quick overview of your current project and task data.
    </p>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Projects</h3>
            <p><?php echo $total_projects; ?></p>
        </div>

        <div class="card">
            <h3>Total Tasks</h3>
            <p><?php echo $total_tasks; ?></p>
        </div>

        <div class="card">
            <h3>Pending Tasks</h3>
            <p><?php echo $pending_tasks; ?></p>
        </div>

        <div class="card">
            <h3>Completed Tasks</h3>
            <p><?php echo $completed_tasks; ?></p>
        </div>
    </div>

    <div class="dashboard-links">
        <a href="dashboard.php" class="dashboard-btn">Refresh Dashboard</a>
        <a href="logout.php" class="dashboard-btn secondary-btn">Logout</a>
    </div>
</div>

<?php include 'include/footer.php'; ?>