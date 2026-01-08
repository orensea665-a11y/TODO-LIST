<?php
// Database configuration
$host = 'localhost'; // Change if needed
$dbname = 'todo_app';
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}
?>