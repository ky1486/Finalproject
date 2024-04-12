<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_name']) && isset($_POST['team_name'])) {
    $board_name = $_POST["board_name"];
    $team_name = $_POST["team_name"];
    $username = $_SESSION['username']; // Get username from session

    // Insert team board into database
    $stmt = $conn->prepare("INSERT INTO Boards (board_name, created_by) VALUES (?, (SELECT user_id FROM Users WHERE username = ?))");
    $stmt->bind_param("ss", $board_name, $username);
    
    if ($stmt->execute()) {
        $board_id = $stmt->insert_id; // Get the ID of the newly created board

        // Insert team board details into Team_Boards table
        $stmt_team = $conn->prepare("INSERT INTO Team_Boards (board_id, team_name, created_by) VALUES (?, ?, (SELECT user_id FROM Users WHERE username = ?))");
        $stmt_team->bind_param("iss", $board_id, $team_name, $username);
        $stmt_team->execute();

        $_SESSION['board_id'] = $board_id; // Store board ID in session for later use
        $_SESSION['team_board_id'] = $conn->insert_id; // Store team board ID in session for later use
        header("Location: ../view/invite_users_form.php");
        exit;
    } else {
        if ($conn->errno == 1062) { // Error number for duplicate entry
            $_SESSION['error'] = "Board name already exists. Please choose a different name.";
        } else {
            $_SESSION['error'] = "Failed to create team board.";
        }
        header("Location: ../view/create_team_board.php");
        exit;
    }
} else {
    header("Location: ../view/create_team_board.php");
    exit;
}
?>
