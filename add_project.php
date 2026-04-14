<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$project_name = '';
$description = '';
$priority = 'medium';
$status = 'active';
$due_date = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_name = sanitize($_POST['project_name']);
    $description = sanitize($_POST['description']);
    $priority = sanitize($_POST['priority']);
    $status = sanitize($_POST['status']);
    $due_date = trim($_POST['due_date']);

    // Validation
    if (empty($project_name)) {
        $errors['project_name'] = "Project name is required.";
    } elseif (strlen($project_name) < 3) {
        $errors['project_name'] = "Project name must be at least 3 characters.";
    }

    $allowed_priorities = ['low', 'medium', 'high'];
    if (!in_array($priority, $allowed_priorities)) {
        $errors['priority'] = "Invalid priority value.";
    }

    $allowed_statuses = ['active', 'completed', 'on_hold'];
    if (!in_array($status, $allowed_statuses)) {
        $errors['status'] = "Invalid status value.";
    }

    if (!empty($due_date)) {
        $date_check = DateTime::createFromFormat('Y-m-d', $due_date);
        if (!$date_check || $date_check->format('Y-m-d') !== $due_date) {
            $errors['due_date'] = "Please enter a valid date.";
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO projects (user_id, project_name, description, priority, status, due_date)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        $success = $stmt->execute([
            $_SESSION['user_id'],
            $project_name,
            $description,
            $priority,
            $status,
            !empty($due_date) ? $due_date : null
        ]);

        if ($success) {
            setMessage('success', 'Project added successfully.');
            redirect('projects.php');
        } else {
            setMessage('error', 'Something went wrong. Please try again.');
        }
    }
}

include 'include/header.php';
?>

<div class="container form-page">
    <h2>Add New Project</h2>

    <?php displayMessage(); ?>

    <form action="add_project.php" method="POST">
        <label for="project_name">Project Name</label>
        <input type="text" name="project_name" id="project_name" value="<?php echo htmlspecialchars($project_name); ?>">
        <?php if (isset($errors['project_name'])): ?>
            <div class="error-text"><?php echo $errors['project_name']; ?></div>
        <?php endif; ?>

        <label for="description">Description</label>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($description); ?>">

        <label for="priority">Priority</label>
        <select name="priority" id="priority">
            <option value="low" <?php echo $priority === 'low' ? 'selected' : ''; ?>>Low</option>
            <option value="medium" <?php echo $priority === 'medium' ? 'selected' : ''; ?>>Medium</option>
            <option value="high" <?php echo $priority === 'high' ? 'selected' : ''; ?>>High</option>
        </select>
        <?php if (isset($errors['priority'])): ?>
            <div class="error-text"><?php echo $errors['priority']; ?></div>
        <?php endif; ?>

        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Completed</option>
            <option value="on_hold" <?php echo $status === 'on_hold' ? 'selected' : ''; ?>>On Hold</option>
        </select>
        <?php if (isset($errors['status'])): ?>
            <div class="error-text"><?php echo $errors['status']; ?></div>
        <?php endif; ?>

        <label for="due_date">Due Date</label>
        <input type="date" name="due_date" id="due_date" value="<?php echo htmlspecialchars($due_date); ?>">
        <?php if (isset($errors['due_date'])): ?>
            <div class="error-text"><?php echo $errors['due_date']; ?></div>
        <?php endif; ?>

        <button type="submit">Save Project</button>
    </form>

    <div class="link-text">
        <a href="projects.php">Back to Projects</a>
    </div>
</div>

<?php include 'include/footer.php'; ?>