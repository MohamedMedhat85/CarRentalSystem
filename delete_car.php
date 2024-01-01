<?php
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    // Redirect to a non-admin page or display an error message
    echo "You do not have permission to access this page.";
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'registration');
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the carId parameter is set
if (isset($_GET['carId'])) {
    $carId = $_GET['carId'];

    // Prepare and execute the SQL statement to delete the car
    $sql = "UPDATE car SET status = 'deleted' WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $carId);

    if ($stmt->execute()) {
        // Deletion successful
        header("Location: admin.php");
    } else {
        // Deletion failed
        header("Location: admin.php");
    }

    $stmt->close();
}

$conn->close();
?>
