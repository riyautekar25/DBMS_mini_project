<?php
$servername = "localhost";
$username = "root";
$password = "Admin123";  // Provide your MySQL password here
$database = "forum";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>