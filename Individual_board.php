<?php
session_start();

// Include database connection
include '../settings/connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual Board</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins: 200,300,400,500,600,700,800,900&display=swap');
        /* Global Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        body {
            font-family: "Poppins", sans-serif;
        
            background-image: url('https://source.unsplash.com/1600x900/?office');
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 750px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        h1, h2, h3 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23333"><path d="M7 10l5 5 5-5H7z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background-color: #f0f0f0;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .reminder {
            background-color: #fff;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .no-reminders {
            color: #777;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .task-section {
            width: calc(33.33% - 10px);
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .task-section h2 {
            margin-bottom: 10px;
            color: #333;
            font-size: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .task-section ul {
            padding: 0;
        }

        .task-section ul li {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .task-section ul li:last-child {
            margin-bottom: 0;
        }

        .attachment-form label,
        .attachment-form input[type="file"] {
            display: block;
            margin-bottom: 10px;
        }

        .attachment-form input[type="file"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }

        .logout-btn {
            
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

       
    </style>
</head>
<body>
    <div class="container">
        <h1>Individual Board</h1>

        <!-- Task creation form -->
        <form action="../action/create_task_action.php" method="post" class="form-section">
            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" required><br>
            <br>
            <label for="assignee_username">Assignee Username:</label>
            <input type="text" id="assignee_username" name="assignee_username" required>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Not Started">Not Started</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <button type="submit" name="create_task">Create Task</button>
        </form>

        <!-- Inside the task editing form -->
        <form action="../action/update_due_date_action.php" method="post" class="form-section">
            <label for="task_name_due">Task Name to Update Due Date:</label>
            <input type="text" id="task_name_due" name="task_name_due" required>
            <label for="new_due_date">New Due Date:</label>
            <input type="date" id="new_due_date" name="new_due_date" required>
            <button type="submit" name="update_due_date">Update Due Date</button>
        </form>

        <!-- Task editing form -->
        <form action="../action/edit_task_action.php" method="post" class="form-section">
            <label for="old_task_name">Old Task Name:</label>
            <input type="text" id="old_task_name" name="old_task_name" required>
            <label for="new_task_name">New Task Name:</label>
            <input type="text" id="new_task_name" name="new_task_name" required>
            <label for="new_description">New Description:</label>
            <textarea id="new_description" name="new_description" rows="4" cols="50"></textarea>
            <button type="submit" name="update_task">Update Task</button>
        </form>

        <!-- Task deletion form -->
        <form action="../action/delete_task_action.php" method="post" class="form-section">
            <label for="delete_task_name">Task Name to Delete:</label>
            <input type="text" id="delete_task_name" name="delete_task_name" required>
            <button type="submit" name="delete_task">Delete Task</button>
        </form>
        <br>

        <div class="flex-container">
            <div class="task-section">
            <h2><span style="color: red;">Not Started</span></h2>
                <ul>
                <?php
    // Fetch and display tasks with status 'Not Started'
    $stmt = $conn->prepare("SELECT * FROM Tasks WHERE board_id = ? AND status = 'Not Started'");
    $stmt->bind_param("i", $_SESSION['board_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $task_name = $row['task_name'];
        $description = $row['description'];
      
        echo "<li>{$task_name} - {$description}</li>";
    }
    ?>
                </ul>
            </div>

            <div class="task-section">
            <h2><span style="color: orange;">In Progress</span></h2>
                <ul>
                <?php
    // Fetch and display tasks with status 'In Progress'
    $stmt = $conn->prepare("SELECT * FROM Tasks WHERE board_id = ? AND status = 'In Progress'");
    $stmt->bind_param("i", $_SESSION['board_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $task_name = $row['task_name'];
        $description = $row['description'];
        echo "<li>{$task_name} - {$description}</li>";
    }
    ?>
                </ul>
            </div>

            <div class="task-section">
            <h2><span style="color: green;">Completed</span></h2>
                <ul>
                <?php
// Fetch and display tasks with status 'Completed'
$stmt = $conn->prepare("SELECT * FROM Tasks WHERE board_id = ? AND status = 'Completed'");
$stmt->bind_param("i", $_SESSION['board_id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $task_name = $row['task_name'];
    $description = $row['description'];
    
    
    echo "<li>{$task_name} - {$description}</li>";
}
?>
                </ul>
            </div>
        </div>

        <!-- Task status update form -->
        <form action="../action/update_progress_action.php" method="post" class="form-section">
            <label for="task_name">Task Name to Update Status:</label>
            <input type="text" id="task_name" name="task_name" required>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Not Started">Not Started</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <button type="submit" name="update_status">Update Status</button>
        </form>

 


        <!-- Task Reminders -->
        <?php

// Array to store reminders
$reminders = [];

// Retrieve tasks from the database
$stmt = $conn->prepare("SELECT task_name, due_date FROM Tasks WHERE  board_id=? And status!= 'Completed'");
$stmt->bind_param("i", $_SESSION['board_id']);
$stmt->execute();
$result = $stmt->get_result();

// Current date
$current_date = date("Y-m-d");

// Check if the due date of each task is 3 days from the current date
while ($row = $result->fetch_assoc()) {
    $task_name = $row['task_name'];
    $due_date = $row['due_date'];

    // Calculate the difference between due date and current date in days
    $diff = strtotime($due_date) - strtotime($current_date);
    $days_until_due = floor($diff / (60 * 60 * 24));

    // If the due date is 3 days from the current date, add a reminder to the array
    if ($days_until_due <= 3) {
        $reminders[] = "Task '{$task_name}' is due in  $days_until_due day(s).";
    }
}
?>
         <!-- Logout button -->
         <form action="../action/logout_action.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        <h1>Task Reminders</h1>
        <?php
        // Display reminders
        
        if (!empty($reminders)) {
            echo "<div class='reminder'><h2>Task Reminders</h2><ul>";
            foreach ($reminders as $reminder) {
                echo "<li>{$reminder}</li>";
            }
            echo "</ul></div>";
        } else {
            echo "<p class='no-reminders'>No reminders at the moment.</p>";
        }
        ?>
    </div>
    <script>
    // Get the input field
    var dueDateInput = document.getElementById("due_date");

    // Add an event listener to listen for changes in the input field
    dueDateInput.addEventListener("change", function() {
        // Get the value entered by the user
        var enteredDate = new Date(dueDateInput.value);
        
        // Format the date to YYYY-MM-DD
        var formattedDate = enteredDate.getFullYear() + '-' + 
                            ('0' + (enteredDate.getMonth() + 1)).slice(-2) + '-' + 
                            ('0' + enteredDate.getDate()).slice(-2);
        
        // Set the value of the input field to the formatted date
        dueDateInput.value = formattedDate;
    });
</script>

       
</body>
</html>
