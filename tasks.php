<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$user_id = $_SESSION['user_id'];

$project_filter_id = null;
$selected_project_name = '';

// Check optional project filter
if (isset($_GET['project_id']) && is_numeric($_GET['project_id'])) {
    $project_filter_id = (int) $_GET['project_id'];

    $project_check_sql = "SELECT project_name FROM projects WHERE id = ? AND user_id = ?";
    $project_check_stmt = $pdo->prepare($project_check_sql);
    $project_check_stmt->execute([$project_filter_id, $user_id]);
    $project_row = $project_check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($project_row) {
        $selected_project_name = $project_row['project_name'];
    } else {
        $project_filter_id = null;
    }
}

// Fetch tasks
if ($project_filter_id !== null) {
    $sql = "SELECT tasks.*, projects.project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE tasks.user_id = ? AND tasks.project_id = ?
            ORDER BY tasks.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $project_filter_id]);
} else {
    $sql = "SELECT tasks.*, projects.project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE tasks.user_id = ?
            ORDER BY tasks.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
}

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'include/header.php';
?>

<div class="container task-page">
    <div class="page-header">
        <h2>My Tasks</h2>
        <a href="add_task.php" class="dashboard-btn">Add New Task</a>
    </div>

    <?php displayMessage(); ?>

    <?php if ($project_filter_id !== null): ?>
        <div class="filter-note">
            <p>Showing tasks for project: <strong><?php echo htmlspecialchars($selected_project_name); ?></strong></p>
            <a href="tasks.php" class="dashboard-btn secondary-btn">View All Tasks</a>
        </div>
    <?php endif; ?>

    <?php if (count($tasks) > 0): ?>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Task Title</th>
                    <th>Project</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['task_title']); ?></td>
                        <td><?php echo htmlspecialchars($task['project_name']); ?></td>
                        <td>
                            <?php echo !empty($task['task_description']) ? htmlspecialchars($task['task_description']) : 'N/A'; ?>
                        </td>
                        <td><?php echo htmlspecialchars($task['priority']); ?></td>
                        <td><?php echo htmlspecialchars($task['status']); ?></td>
                        <td>
                            <?php echo !empty($task['due_date']) ? htmlspecialchars($task['due_date']) : 'N/A'; ?>
                        </td>
                        <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                        <td>
                            <a href="#" class="action-link disabled-link">Edit</a>
                            <a href="#" class="action-link disabled-link">Delete</a>
                            <a href="#" class="action-link disabled-link">Update Status</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-box">
            <p>You have not created any tasks yet.</p>
            <a href="add_task.php" class="dashboard-btn">Create Your First Task</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>