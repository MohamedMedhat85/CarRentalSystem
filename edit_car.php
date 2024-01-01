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

$carModel = $_POST['car_model'];
$year = $_POST['year'];
$plateID = $_POST['plate_id'];
$carImage = $_POST['car_image'];
$carPrice = $_POST['car_price'];


// Check if the carId parameter is set
if (isset($_GET['carId'])) {
    $carId = $_GET['carId'];
    ////////
    if ($carModel == null || $year == null || $plateID == null || $carImage == null || $carPrice == null) {
        $sqlSelect = "SELECT car_model, year, plate_id, image, price FROM car WHERE car_id=?";
        $stmtSelect = $conn->prepare($sqlSelect);

        if ($stmtSelect) {
            $stmtSelect->bind_param("i", $carId);
            $stmtSelect->execute();
            $stmtSelect->bind_result($origModel, $origYear, $origPlateID, $origImage, $origPrice);
            $stmtSelect->fetch();

            // Update variables with original values if they are null
            if($year == null){
                $year = $origYear;
            }
            if($plateID == null){
                $plateID = $origPlateID;
            }
            if($carImage == null){
                $carImage = $origImage;
            }
            if($carModel == null){
                $carModel = $origModel;
            }
            if($carPrice == null){
                $carPrice = $origPrice;
            }

            $stmtSelect->close();
        } else {
            echo "Error in preparing the SQL statement for SELECT.";
            exit();
        }
    }

    ////////

    $sql = "UPDATE car SET car_model=?, year=?, plate_id=?, image=?, price =? WHERE car_id=?";

    // Prepare and execute the SQL statement to update the car
    $stmt = $conn->prepare($sql);

    // Check if the statement is prepared successfully
    if ($stmt) {
        $stmt->bind_param("sissdi", $carModel, $year, $plateID, $carImage, $carPrice, $carId);

        if ($stmt->execute()) {
            // Update successful
            header("Location: admin.php");
        } else {
            // Update failed
            header("Location: admin.php");
        }

        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "Error in preparing the SQL statement.";
    }
} else {
    // carId parameter is not set
    echo "carId parameter is not set.";
}

$conn->close();
?>
