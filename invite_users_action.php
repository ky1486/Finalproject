<?php
session_start();

// Include database connection
include '../settings/connection.php';



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['invite_users']) && isset($_POST['team_board_id'])) {
    // Get the team board ID and user emails from the form
    $team_board_id = $_POST['team_board_id'];
    $user_emails = explode(",", $_POST['user_emails']); // Split comma-separated emails into an array

    // Check if the team board exists
    $stmt_check_board = $conn->prepare("SELECT team_board_id FROM Team_Boards WHERE team_board_id = ?");
    $stmt_check_board->bind_param("i", $team_board_id);
    $stmt_check_board->execute();
    $result_check_board = $stmt_check_board->get_result();

    if ($result_check_board->num_rows == 0) {
        $_SESSION['error'] = "Team board not found.";
        header("Location: ../view/invite_users_form.php");
        exit;
    }

    // Iterate through each email and invite the users to join the team board
    foreach ($user_emails as $email) {
        $email = trim($email); // Remove whitespace
        // Check if the user exists
        $stmt_check_user = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
        $stmt_check_user->bind_param("s", $email);
        $stmt_check_user->execute();
        $result_check_user = $stmt_check_user->get_result();

        if ($result_check_user->num_rows > 0) {
            $row = $result_check_user->fetch_assoc();
            $user_id = $row['user_id'];

            // Add the user to the Team_members table
            $stmt_add_member = $conn->prepare("INSERT INTO Team_members (team_board_id, user_id) VALUES (?, ?)");
            $stmt_add_member->bind_param("ii", $team_board_id, $user_id);
            if ($stmt_add_member->execute()) {
               echo "You have successfully added . $email . to the team board";

             
            } else {
                $_SESSION['error'] = "Failed to invite user with email: $email. Error: " . $conn->error;
            }
        } else {
            $_SESSION['error'] = "User with email: $email not found.";
        }
    }

    $_SESSION['success'] = "Users invited successfully.";
    header("Location: ../view/team_board.php");
    exit;
} else {
    // Redirect to the homepage if accessed directly
    header("Location: ../index.php");
    exit;
}
?>
