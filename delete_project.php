<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setMessage('error', 'Invalid project ID.');
    redirect('projects.php');
}

$project_id = (int) $_GET['id'];

// Make sure the project belongs to current user
$sql = "SELECT id FROM projects WHERE id = ? AND user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$project_id, $user_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    setMessage('error', 'Project not found or access denied.');
    redirect('projects.php');
}

// Delete the project
$delete_sql = "DELETE FROM projects WHERE id = ? AND user_id = ?";
$delete_stmt = $pdo->prepare($delete_sql);
$success = $delete_stmt->execute([$project_id, $user_id]);

if ($success) {
    setMessage('success', 'Project deleted successfully.');
} else {
    setMessage('error', 'Failed to delete project.');
}

redirect('projects.php');
?>