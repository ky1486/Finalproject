<?php
session_start();

// Include database connection
include '../settings/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_name'])) {
    $board_name = $_POST["board_name"];

    // Check if the board already exists in the database
    $stmt_check_board = $conn->prepare("SELECT board_id FROM Boards WHERE board_name = ?");
    $stmt_check_board->bind_param("s", $board_name);
    $stmt_check_board->execute();
    $result_check_board = $stmt_check_board->get_result();

    if ($result_check_board->num_rows > 0) {
        // Board exists, fetch the board ID
        $row_board = $result_check_board->fetch_assoc();
        $board_id = $row_board['board_id'];

        // Check if the user is a member of the team associated with the board
        $username = $_SESSION['username']; // Assuming username is stored in session
        $stmt_check_membership = $conn->prepare("SELECT * FROM Team_members tm JOIN Team_Boards tb ON tm.team_board_id = tb.team_board_id JOIN Users u ON tm.user_id = u.user_id WHERE u.username = ? AND tb.board_id = ?");
        $stmt_check_membership->bind_param("si", $username, $board_id);
        $stmt_check_membership->execute();
        $result_check_membership = $stmt_check_membership->get_result();

        if ($result_check_membership->num_rows > 0) {
            // User is a member of the team associated with the board, redirect to the board view
            $_SESSION['board_id'] = $board_id; // Store board ID in session for later use
            header("Location: ../view/team_board.php");
            exit;
        } else {
            // User is not a member of the team associated with the board, redirect with an error message
            $_SESSION['error'] = "You are not a member of the team associated with this board.";
            header("Location: ../view/create_team_board.php");
            exit;
        }
    } else {
        // Board does not exist, redirect with an error message
        $_SESSION['error'] = "Board does not exist.";
        header("Location: ../view/create_team_board.php");
        exit;
    }
} else {
    // Redirect to the create board page if accessed directly
    header("Location: ../view/create_team_board.php");
    exit;
}
?>
