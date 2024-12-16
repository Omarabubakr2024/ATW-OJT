<?php
$servername = "localhost";
$username = "web_user";
$password = "StrongPassword123";
$dbname = "web_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ip = $_SERVER['REMOTE_ADDR'];
$time = date("Y-m-d H:i:s");

echo "Hello! Your IP address is $ip. Current time is $time.";
$conn->close();
?>
