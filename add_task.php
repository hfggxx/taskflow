<?php
require_once 'include/auth_check.php';
require_once 'include/dbconnect.php';
require_once 'include/functions.php';

$user_id = $_SESSION['user_id'];
$errors = [];

// Fetch current user's projects first
$project_sql = "SELECT id, project_name FROM projects WHERE user_id = ? ORDER BY created_at DESC";
$project_stmt = $pdo->prepare($project_sql);
$project_stmt->execute([$user_id]);
$projects = $project_stmt->fetchAll(PDO::FETCH_ASSOC);

$task_title = '';
$task_description = '';
$project_id = '';
$priority = 'medium';
$status = 'pending';
$due_date = '';

// If no projects exist, show message
if (count($projects) === 0) {
    include 'include/header.php';
    ?>
    <div class="container form-page">
        <h2>Add New Task</h2>
        <div class="empty-box">
            <p>You need to create a project before adding tasks.</p>
            <a href="add_project.php" class="dashboard-btn">Create Project First</a>
        </div>
    </div>
    <?php
    include 'include/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_title = sanitize($_POST['task_title']);
    $task_description = sanitize($_POST['task_description']);
    $project_id = $_POST['project_id'];
    $priority = sanitize($_POST['priority']);
    $status = sanitize($_POST['status']);
    $due_date = trim($_POST['due_date']);

    // Validate task title
    if (empty($task_title)) {
        $errors['task_title'] = "Task title is required.";
    } elseif (strlen($task_title) < 3) {
        $errors['task_title'] = "Task title must be at least 3 characters.";
    }

    // Validate project selection
    if (empty($project_id) || !is_numeric($project_id)) {
        $errors['project_id'] = "Please select a valid project.";
    } else {
        $valid_project = false;
        foreach ($projects as $project) {
            if ((int)$project['id'] === (int)$project_id) {
                $valid_project = true;
                break;
            }
        }

        if (!$valid_project) {
            $errors['project_id'] = "Selected project is invalid.";
        }
    }

    // Validate priority
    $allowed_priorities = ['low', 'medium', 'high'];
    if (!in_array($priority, $allowed_priorities)) {
        $errors['priority'] = "Invalid priority value.";
    }

    // Validate status
    $allowed_statuses = ['pending', 'in_progress', 'completed'];
    if (!in_array($status, $allowed_statuses)) {
        $errors['status'] = "Invalid status value.";
    }

    // Validate due date
    if (!empty($due_date)) {
        $date_check = DateTime::createFromFormat('Y-m-d', $due_date);
        if (!$date_check || $date_check->format('Y-m-d') !== $due_date) {
            $errors['due_date'] = "Please enter a valid date.";
        }
    }

    // Insert task
    if (empty($errors)) {
        $insert_sql = "INSERT INTO tasks (project_id, user_id, task_title, task_description, priority, status, due_date)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $pdo->prepare($insert_sql);

        $success = $insert_stmt->execute([
            $project_id,
            $user_id,
            $task_title,
            $task_description,
            $priority,
            $status,
            !empty($due_date) ? $due_date : null
        ]);

        if ($success) {
            setMessage('success', 'Task added successfully.');
            redirect('tasks.php');
        } else {
            setMessage('error', 'Something went wrong. Please try again.');
        }
    }
}

include 'include/header.php';
?>

<div class="container form-page">
    <h2>Add New Task</h2>

    <?php displayMessage(); ?>

    <form action="add_task.php" method="POST">
        <label for="task_title">Task Title</label>
        <input type="text" name="task_title" id="task_title" value="<?php echo htmlspecialchars($task_title); ?>">
        <?php if (isset($errors['task_title'])): ?>
            <div class="error-text"><?php echo $errors['task_title']; ?></div>
        <?php endif; ?>

        <label for="task_description">Description</label>
        <textarea name="task_description" id="task_description" rows="4"><?php echo htmlspecialchars($task_description); ?></textarea>

        <label for="project_id">Project</label>
        <select name="project_id" id="project_id">
            <option value="">Select a project</option>
            <?php foreach ($projects as $project): ?>
                <option value="<?php echo $project['id']; ?>" <?php echo ((string)$project_id === (string)$project['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($project['project_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['project_id'])): ?>
            <div class="error-text"><?php echo $errors['project_id']; ?></div>
        <?php endif; ?>

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
            <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="in_progress" <?php echo $status === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
            <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>
        <?php if (isset($errors['status'])): ?>
            <div class="error-text"><?php echo $errors['status']; ?></div>
        <?php endif; ?>

        <label for="due_date">Due Date</label>
        <input type="date" name="due_date" id="due_date" value="<?php echo htmlspecialchars($due_date); ?>">
        <?php if (isset($errors['due_date'])): ?>
            <div class="error-text"><?php echo $errors['due_date']; ?></div>
        <?php endif; ?>

        <button type="submit">Save Task</button>
    </form>

    <div class="link-text">
        <a href="tasks.php">Back to Tasks</a>
    </div>
</div>

<?php include 'include/footer.php'; ?>