<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login if user is not logged in
    exit();
}

include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskTitle = $conn->real_escape_string($_POST['taskTitle']);
    $taskDescription = $conn->real_escape_string($_POST['taskDescription']);
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $userId = $_SESSION['id']; // Assuming user ID is stored in session as 'id' after login

    // Ensure the task table has columns: 'user_id', 'task_title', 'task_description', 'deadline'
    $sql = "INSERT INTO tasks (user_id, task_title, task_description, deadline) 
            VALUES ('$userId', '$taskTitle', '$taskDescription', '$deadline')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Task created successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>
