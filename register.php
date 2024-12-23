<?php 

include 'connect.php';

if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password); // Hash the password for security

    // Check if the username already exists
    $checkUsername = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($checkUsername);
    
    if ($result->num_rows > 0) {
        echo "Username already exists!";
    } else {
        // Insert the new user into the database
        $insertQuery = "INSERT INTO users(username, password) VALUES ('$username', '$password')";
        
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: login.html"); // Redirect to the login page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password); // Hash the input password for comparison

    // Verify the credentials
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        header("Location: homepage.php"); // Redirect to the homepage
        exit();
    } else {
        echo "Incorrect username or password.";
    }
}
?> 
