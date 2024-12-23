<?php
// Database connection details
$servername = "localhost"; // Default localhost for XAMPP
$username = "root";        // Default MySQL username in XAMPP
$password = "";            // Default MySQL password (empty in XAMPP)
$dbname = "inventory_goods"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>
