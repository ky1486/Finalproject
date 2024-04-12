<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $task_name = $_POST["task_name"];
    $status = $_POST["status"];

    // Update task status in database
    $stmt = $conn->prepare("UPDATE Tasks SET status = ? WHERE task_name = ?");
    $stmt->bind_param("ss", $status, $task_name);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task status updated successfully.";
        header("Location: ../view/Individual_board.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to update task status.";
        header("Location: ../view/Individual_board.php");
        exit;
    }
} else {
    header("Location: ../view/Individual_board.php");
    exit;
}
?>
