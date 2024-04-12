<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])) {
    $delete_task_name = $_POST["delete_task_name"];

    // Delete task from database
    $stmt = $conn->prepare("DELETE FROM Tasks WHERE task_name = ?");
    $stmt->bind_param("s", $delete_task_name);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task deleted successfully.";
        header("Location: ../view/Individual_board.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to delete task.";
        header("Location: ../view/Individual_board.php");
        exit;
    }
} else {
    header("Location: ../view/Individual_board.php");
    exit;
}
?>
