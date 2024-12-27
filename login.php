<?php
session_start();

// Database connection details
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "personal_task";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password hash
        if (password_verify($password, $user["password"])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION["username"] = $user["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<p style='color:red;'>Invalid username or password.</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid username or password.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
