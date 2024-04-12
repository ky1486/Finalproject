<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $old_task_name = $_POST["old_task_name"];
    $new_task_name = $_POST["new_task_name"];
    $new_description = $_POST["new_description"];

    // Update task name and description in database
    $stmt = $conn->prepare("UPDATE Tasks SET task_name = ?, description = ? WHERE task_name = ?");
    $stmt->bind_param("sss", $new_task_name, $new_description, $old_task_name);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task name and description updated successfully.";
        header("Location: ../view/Individual_board.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to update task name and description.";
        header("Location: ../view/Individual_board.php");
        exit;
    }
} else {
    header("Location: ../view/Individual_board.php");
    exit;
}
?>
