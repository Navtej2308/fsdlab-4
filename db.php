<?php
// db.php
$servername = "localhost";
$username = "root";
$password = "Navtej#2308";  // your MySQL password
$dbname = "student_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
