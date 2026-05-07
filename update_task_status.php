<?php
require_once 'include/dbconnect.php';
require_once 'include/auth_check.php';

if(isset($_POST['task_id'], $_POST['status'])){
    $stmt = $pdo->prepare("UPDATE tasks SET status=? WHERE id=? AND user_id=?");
    $stmt->execute([$_POST['status'], $_POST['task_id'], $_SESSION['user_id']]);
}