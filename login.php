<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "personal_task";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION["username"] = $username;
    header("Location: dashboard.php");
  } else {
    echo "Invalid username or password.";
  }
}
mysqli_close($conn);
?>