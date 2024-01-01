<?php
session_start();
// Retrieve data from the HTML form
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
function validateEmail($email) {
    // Define a regular expression pattern for a valid email address
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    // Use the preg_match() function to check if the email matches the pattern
    if (preg_match($pattern, $email)) {
        return true; // Valid email format
    } else {
        return false; // Invalid email format
    }
}

if (validateEmail($email)) {
    $conn = new mysqli('localhost', 'root', '', 'registration');
    if($conn->connect_error){
        die('Connection Failed :'.$conn->connect_error);
        }     
        else{
        $check_email = $conn->prepare("SELECT email FROM user WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->store_result();

        if ($check_email->num_rows > 0) {
            header("Location: Registeration.html?error=email_exists");
        }
        else{
            if($_SESSION['role'] != 'admin'){            
                $encryptedPassword = md5($password);
                $stmt = $conn->prepare("insert into user(email, name ,password)
                values(?, ?, ?)");
                $stmt->bind_param("sss", $email,  $name, $encryptedPassword);    
                if ($stmt->execute()) {
                header("Location: login.html");
                $stmt->close();
            }
            } 
            if ($_SESSION['role'] == 'admin') {
                $encryptedPassword = md5($password);
                $stmt = $conn->prepare("insert into user(email, name ,password, role)
                values(?, ?, ?, ?)");

                $stmt->bind_param("ssss", $email,  $name, $encryptedPassword, $_SESSION['role']);    
                if ($stmt->execute()) {
                    header("Location: admin.php");
                } 
                $stmt->close();
            }
    }
    $conn->close();
}
}
else{
    header("Location: Registeration.html?error=email_invalid");
}


?>
