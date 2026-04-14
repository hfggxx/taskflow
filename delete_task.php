<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setMessage('error', 'Invalid task ID.');
    redirect('tasks.php');
}

$task_id = (int) $_GET['id'];

// Make sure the task belongs to current user
$sql = "SELECT id FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    setMessage('error', 'Task not found or access denied.');
    redirect('tasks.php');
}

// Delete task
$delete_sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
$delete_stmt = $pdo->prepare($delete_sql);
$success = $delete_stmt->execute([$task_id, $user_id]);

if ($success) {
    setMessage('success', 'Task deleted successfully.');
} else {
    setMessage('error', 'Failed to delete task.');
}

redirect('tasks.php');
?>