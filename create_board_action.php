<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_name'])) {
    $board_name = $_POST["board_name"];
    $username = $_SESSION['username']; // Get username from session

    // Insert board into database
    $stmt = $conn->prepare("INSERT INTO Boards (board_name, created_by) VALUES (?, (SELECT user_id FROM Users WHERE username = ?))");
    $stmt->bind_param("ss", $board_name, $username);
    
    if ($stmt->execute()) {
        $board_id = $stmt->insert_id; // Get the ID of the newly created board
        $_SESSION['board_id'] = $board_id; // Store board ID in session for later use
        header("Location: ../view/Individual_board.php");
        exit;
    } else {
        if (strpos($stmt->error, "Duplicate entry") !== false) { // Check if the error message contains "Duplicate entry"
            $_SESSION['error'] = "Board name already exists. Please choose a different name.";
        } else {
            $_SESSION['error'] = "Failed to create board.";
        }
        header("Location: ../view/create_board.php");
        exit;
    }
} else {
    header("Location: ../view/create_board.php");
    exit;
}
?>
