<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            // Redirect to the login page if not logged in
            header("Location: login.html");
            exit();
        }
if(isset($_GET['carId'])) {
    // Retrieve the value of the 'id' parameter
    $car_id = $_GET['carId'];
}

$conn = new mysqli('localhost', 'root', '', 'registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample data to be inserted
$user_id = $_SESSION['user_id'];
///////////
$sql = "SELECT price FROM car WHERE car_id = $car_id" ;
 $result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
$carPrice=$row["price"];



////////////

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO reservations (user_id, car_id, rent_price) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Error in statement preparation: " . $conn->error);
}
$stmt->bind_param("iid", $user_id, $car_id, $carPrice);
///////////////////
$sql = "UPDATE car SET status = 'rented' WHERE car_id = $car_id";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
}

// Execute the statement
if ($stmt->execute()) {
    header("Location: customer.php");
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>