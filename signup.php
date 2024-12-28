<?php 
include 'connect.php'; 

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // SIGN UP
    if (isset($_POST['signUp'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);  // Plain password
        
        // Debug information
        echo "Inputs:<br> $fname, $lname, $username<br>";
        echo "Password: $password<br>";  // You can remove this in a production environment for security reasons

        // Check if the username already exists
        $checkUsername = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();
        $result = $checkUsername->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username already exists! Please choose another.'); window.location.href='./signup.html';</script>";
        } else {
            // Insert the new user into the database
            $insertQuery = $conn->prepare("INSERT INTO users (fname, lname, username, password) VALUES (?, ?, ?, ?)");
            $insertQuery->bind_param("ssss", $fname, $lname, $username, $password);  // Storing password in plain text
            
            if ($insertQuery->execute()) {
                echo "<script>alert('Registration successful! Please log in.'); window.location.href='./login.html';</script>";
                exit();  // Ensure we exit here so no further code executes after the redirect
            } else {
                echo "<script>alert('Error during registration: " . $conn->error . "');</script>";
            }
        }
        $checkUsername->close();
        $insertQuery->close();
    }

    // SIGN IN
    if (isset($_POST['signIn'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);  // Plain password

        // Verify the credentials
        $loginQuery = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $loginQuery->bind_param("s", $username);
        $loginQuery->execute();
        $result = $loginQuery->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Validate password
            if ($password == $row['password']) {  // No password hashing comparison
                session_start();
                $_SESSION['username'] = $row['username'];  // Store the username in session
                
                header("Location: dashboard.php");  // Redirect to the dashboard after successful login
                exit();  // Ensure we exit to avoid additional code execution
            } else {
                echo "<script>alert('Incorrect username or password.'); window.location.href='./login.html';</script>";
            }
        } else {
            echo "<script>alert('Incorrect username or password.'); window.location.href='./login.html';</script>";
        }
        $loginQuery->close();
    }
}

$conn->close();
?>
