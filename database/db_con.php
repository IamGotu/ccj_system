<?php
// Database connection
$host = 'localhost';
$db = 'ccj_database';
$user = 'root';
$pass = ''; // Enter your MySQL password here

// Establish connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>