<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_name'])) {
    $board_name = $_POST["board_name"];

    // Check if the board already exists in the database
    $stmt = $conn->prepare("SELECT board_id FROM Boards WHERE board_name = ?");
    $stmt->bind_param("s", $board_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Board already exists, fetch the board ID and redirect the user
        $row = $result->fetch_assoc();
        $board_id = $row['board_id'];
        $_SESSION['board_id'] = $board_id; // Store board ID in session for later use
        header("Location: ../view/Individual_board.php");
        exit;
    } else {
        // Board does not exist, redirect the user with an error message
        $_SESSION['error'] = "Board does not exist.";
        header("Location: ../view/create_board.php");
        exit;
    }
} else {
    header("Location: ../view/create_board.php");
    exit;
}
?>
