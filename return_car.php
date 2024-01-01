<?php
session_start();
// Assuming you're using MySQL
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: customer.php");
    exit();
}
// Create connection
$conn = new mysqli('localhost', 'root', '', 'registration');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the value from the URL
$primaryID = $_GET['Id'];
date_default_timezone_set('Africa/Cairo');

////////
$sql = "SELECT rented_at, rent_price FROM reservations WHERE id = ?";

$stmt = $conn->prepare($sql);
$newStatus = 'returned';
$stmt->bind_param("i", $primaryID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $rentedAt = new DateTime($row["rented_at"]);
    $returnedAt = new DateTime(date('Y-m-d H:i:s'));

    $diff = $rentedAt->diff($returnedAt); 


    // Calculate the Price To Pay
    $total_minutes = ($diff->days * 24); 
    $total_minutes += ($diff->h);
    $total_minutes += $diff->i / 60; 
    $priceToPay = $total_minutes * $row["rent_price"];
    $priceToPay = round($priceToPay, 2);

}
//
$stmt->close();
// Bind parameters



///////
// SQL query to update the column
$sql = "UPDATE reservations SET rent_status = ?, returned_at = ?, price_paid = ? WHERE id = ?";
$currentDateTime = date('Y-m-d H:i:s');
$stmt = $conn->prepare($sql);
$newStatus = 'returned';
// Bind parameters
$stmt->bind_param("ssdi", $newStatus, $currentDateTime, $priceToPay, $primaryID);
$stmt->execute();
$stmt->close();
//////////////////////////////////////////
$sql = "SELECT car_id FROM reservations WHERE id = ?";
$stmt = $conn->prepare($sql);

// Check for errors in preparing the statement
if (!$stmt) {
    die("Error in preparing the statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("i", $primaryID);

// Check for errors in binding parameters
if (!$stmt->bind_param("i", $primaryID)) {
    die("Error in binding parameters: " . $stmt->error);
}

// Execute the statement
$stmt->execute();

// Check for errors in executing the statement
if (!$stmt->execute()) {
    die("Error in executing the statement: " . $stmt->error);
}

// Bind result variables
$stmt->bind_result($car_id);

// Fetch the result
$stmt->fetch();

// Close the statement
$stmt->close();
///////////////////////////////////////////////////////
$sql = "UPDATE car SET status = ? WHERE car_id = ?";
$stmt = $conn->prepare($sql);
$newStatus1 = 'active';
$stmt->bind_param("si", $newStatus1, $car_id);
$stmt->execute();
$stmt->close();
// Close the connection
$conn->close();
header("Location: customer.php");
?>