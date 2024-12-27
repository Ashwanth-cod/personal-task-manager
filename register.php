<?php 
include 'connect.php';

if (isset($_POST['signUp'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Secure hashing

    // Check if the username already exists
    $checkUsername = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();
    $result = $checkUsername->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists!";
    } else {
        // Insert the new user into the database
        $insertQuery = $conn->prepare("INSERT INTO users (fname, lname, username, password) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("ssss", $fname, $lname, $username, $hashedPassword);
        
        if ($insertQuery->execute()) {
            header("Location: login.html"); // Redirect to the login page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
    $checkUsername->close();
    $insertQuery->close();
}

if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify the credentials
    $loginQuery = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $loginQuery->bind_param("s", $username);
    $loginQuery->execute();
    $result = $loginQuery->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.html"); // Redirect to the homepage
            exit();
        } else {
            echo "Incorrect username or password.";
        }
    } else {
        echo "Incorrect username or password.";
    }
    $loginQuery->close();
}

$conn->close();
?>
