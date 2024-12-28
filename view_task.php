<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = $_POST['taskId'];
    $userId = $_SESSION['user_id'];

    $sql = "SELECT task_title, task_description, deadline FROM tasks WHERE id = '$taskId' AND user_id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
        echo "<h2>" . $task['task_title'] . "</h2>";
        echo "<p>" . $task['task_description'] . "</p>";
        echo "<p><strong>Deadline:</strong> " . date('Y-m-d H:i', strtotime($task['deadline'])) . "</p>";  // Display formatted date
    } else {
        echo "<script>alert('Task not found or you do not have permission to view it.'); window.location.href='dashboard.php';</script>";
    }
}

$conn->close();
?>
