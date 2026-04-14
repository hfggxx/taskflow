<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'include/header.php';
?>

<div class="container project-page">
    <div class="page-header">
        <h2>My Projects</h2>
        <a href="add_project.php" class="dashboard-btn">Add New Project</a>
    </div>

    <?php displayMessage(); ?>

    <?php if (count($projects) > 0): ?>
        <table class="project-table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                        <td>
                            <?php echo !empty($project['description']) ? htmlspecialchars($project['description']) : 'N/A'; ?>
                        </td>
                        <td><?php echo htmlspecialchars($project['priority']); ?></td>
                        <td><?php echo htmlspecialchars($project['status']); ?></td>
                        <td>
                            <?php echo !empty($project['due_date']) ? htmlspecialchars($project['due_date']) : 'N/A'; ?>
                        </td>
                        <td><?php echo htmlspecialchars($project['created_at']); ?></td>
                        <td>
                            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="action-link">Edit</a>
                            <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="action-link delete-link" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                            <a href="#" class="action-link disabled-link">Tasks</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-box">
            <p>You have not created any projects yet.</p>
            <a href="add_project.php" class="dashboard-btn">Create Your First Project</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>