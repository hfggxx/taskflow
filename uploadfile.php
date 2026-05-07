<?php
include 'include/dbconnect.php';
if(isset($_FILES['task_file'], $_POST['task_id'])){
    $target="uploads/".basename($_FILES['task_file']['name']);
    if(move_uploaded_file($_FILES['task_file']['tmp_name'],$target)){
        $stmt=$conn->prepare("UPDATE tasks SET file_path=? WHERE task_id=?");
        $stmt->bind_param("si",$target,$_POST['task_id']);
        $stmt->execute();
    }
}
header("Location: tasks.php");
exit();