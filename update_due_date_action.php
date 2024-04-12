<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_name_due']) && isset($_POST['new_due_date'])) {
    $task_name_due = $_POST["task_name_due"];
    $new_due_date = $_POST["new_due_date"];

    // Update the due date of the task in the database
    $stmt = $conn->prepare("UPDATE Tasks SET due_date = ? WHERE task_name = ?");
    $stmt->bind_param("ss", $new_due_date, $task_name_due);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Due date updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update due date.";
    }
    header("Location: ../view/individual_board.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
?>
