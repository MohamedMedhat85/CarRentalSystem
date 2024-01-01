<?php
// Assuming you're using MySQL

// Create connection
$conn = new mysqli('localhost', 'root', '', 'registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the value from the URL
$id = $_GET['carId'];

// SQL query to update the column
$sql = "UPDATE car SET status = ? WHERE car_id = ?";

$stmt = $conn->prepare($sql);
$newStatus = 'active';
// Bind parameters
$stmt->bind_param("si", $newStatus, $id);
$stmt->execute();
$stmt->close();
// Close the connection
$conn->close();
header("Location: admin.php");
?>
