<?php
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$encryptedPassword = md5($password);

$conn = new mysqli('localhost', 'root', '', 'registration');
if($conn->connect_error){
    die('Connection Failed :'.$conn->connect_error);
}
$sql = "SELECT * FROM user WHERE email = '$email' AND password = '$encryptedPassword'";
 $result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['user_status'] == 'blocked'){
        echo "This user has been blocked" ;
    }
    else if($row["role"] == 'admin'){
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_status'] = $row['user_status'];
        header("Location: admin.php");

    }
    else if($row["role"] == 'customer'){
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_status'] = $row['user_status'];
        header("Location: customer.php");
    }
}
else {
    header("Location: login.html?error=wrong-credentials");
}
exit();
?>
