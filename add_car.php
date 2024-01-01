<?php
// Retrieve data from the HTML form
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
else{
    $car_model = $_POST['car_model'];
    $year = $_POST['year'];
    $plate_id = $_POST['plate_id'];
    $image = $_POST['car_image'];
    $price = $_POST['car_price'];
    $office_id = $_POST['office_id'];
    $conn = new mysqli('localhost', 'root', '', 'registration');
    $flag = 0;
    if($conn->connect_error){
        die('Connection Failed :'.$conn->connect_error);
        }    
    else{
        $sql = "SELECT office_id FROM office";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if($row['office_id'] == $office_id){
                    $flag = 1;
                }
            }
            $result->free();
        }
        if($flag == 1){
            $flag = 0;
            $stmt = $conn->prepare("insert into car(car_model, year ,plate_id, image, price, office_id) values(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissdi", $car_model, $year, $plate_id, $image, $price, $office_id);   
            if ($stmt->execute()) {
            header("Location: admin.php");
            } 
            $stmt->close();
        }
        else if($flag == 0)
            header("Location: add_car.html?error=invalid-officeId");
        }
        $conn->close();}
?>
