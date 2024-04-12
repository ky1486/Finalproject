<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_task'])) {
    $task_name = $_POST["task_name"];
    $description = $_POST["description"];
    $due_date = $_POST["due_date"];
    $assignee_username = $_POST["assignee_username"]; // Get assignee username from form
    $status = $_POST["status"];

    // Validate assignee username
    $stmt = $conn->prepare("SELECT user_id FROM Users WHERE username = ?");
    $stmt->bind_param("s", $assignee_username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Invalid assignee username selected.";
        header("Location: ../view/individual_board.php");
        exit;
    }
    $row = $result->fetch_assoc();
    $assignee_id = $row['user_id'];
    $stmt->close();

    // Insert task into database
    $stmt = $conn->prepare("INSERT INTO Tasks (board_id, task_name, description, due_date, assignee_id, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $_SESSION['board_id'], $task_name, $description, $due_date, $assignee_id, $status);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Task created successfully.";
        header("Location: ../view/Individual_board.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to create task.";
        header("Location: ../view/Individual_board.php");
        exit;
    }
} else {
    header("Location: ../view/Individual_board.php");
    exit;
}
?>
