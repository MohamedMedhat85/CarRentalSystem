<?php
// Assuming you're using MySQL
session_start();
// Create connection
$user_id = $_GET['user_id'];
$conn = new mysqli('localhost', 'root', '', 'registration');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to update the column
$sql = "UPDATE user SET user_status = IF(user_status = 'active', 'blocked', 'active') WHERE user_id = ?";

$stmt = $conn->prepare($sql);
// Bind parameters
$stmt->bind_param("i",$user_id);
$stmt->execute();

$stmt->close();
// Close the connection
$conn->close();
if($user_id == $_SESSION['user_id']){
    header("Location: logout.php");
}
else{
    header("Location: admin.php");
}

?>
