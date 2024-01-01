<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="current_cars_for_customer.css">
    <link rel="stylesheet" href="customer.css">
    <script src="customer.js"></script>
    
</head>

<body>
    <?php
    // Start the session
    session_start();
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        header("Location: login.html");
        exit();
    }
    $conn = new mysqli('localhost', 'root', '', 'registration');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT price_paid FROM reservations WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_Price = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()){
            $total_Price += $row['price_paid'];
        }
    }
        

    ////////
    ?>
    <nav class="navbar1">
        <div class="navbar-section">
            <p>Car Rental System</p>
            <button onclick="toggleCarTable()">Cars</button>
        </div>
        <div class="navbar-section">
            <p> <?php echo $_SESSION['email']; ?></p>
            <a href="http://localhost/FinalProject/logout.php">Logout</a>
        </div>
    </nav>
    <nav class="navbar2">
        <div class="navbar-section">
            <button onclick="toggleMyRents()">My Rents</button>
        </div>
        <div class="price-container">
            <div class="price">
                <?php
                echo 'Paid: $', $total_Price;
                ?>
            </div>
        </div>
    </nav>


    <div id="myRentsTable">
    <?php
    $conn = new mysqli('localhost', 'root', '', 'registration');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM reservations JOIN car ON car.car_id = reservations.car_id WHERE user_id = ?  ORDER BY rented_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); // Assuming user_id is an integer, adjust accordingly
    $user_id = $_SESSION['user_id'];/* Set the user ID here */ // Replace this with the actual user ID
    $stmt->execute();
    $result = $stmt->get_result();


    // Step 3: Fetch data and construct HTML table
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>Car ID</th><th>Car Model</th><th>Year</th><th>Plate ID</th><th>Image</th><th>Rented At</th><th>Returned At</th><th>Price Hourly</th><th>Status</th><th>Actions</th><th>Price To Pay</th></tr>";

        while ($row = $result->fetch_assoc()) {
            date_default_timezone_set('Africa/Cairo');
            $_SESSION['car_id'] = $row["car_id"];
            if($row['rent_status'] == 'returned'){
                $priceToPay = $row['price_paid'];
            }
            else{
                $rentedAt = new DateTime($row["rented_at"]);
                $returnedAt = ($row["returned_at"] !== null) ? new DateTime($row["returned_at"]) : $currentDateTime = new DateTime(date('Y-m-d H:i:s'));
    
                $diff = $rentedAt->diff($returnedAt); 
    
               /* $diff->days.' Days total<br>'; 
                $diff->y.' Years<br>'; 
                $diff->m.' Months<br>'; 
                $diff->d.' Days<br>'; 
                $diff->h.' Hours<br>'; 
                $diff->i.' Minutes<br>';*/ 
                
                // Calculate the Price To Pay
                $total_hours = ($diff->days * 24);  
                $total_hours += ($diff->h);
                $total_hours += $diff->i / 60; 
                $priceToPay = $total_hours * $row["price"];
                $priceToPay = round($priceToPay, 2);   
            }

            echo "<tr>
                <td>" . $row["car_id"] . "</td>
                <td>" . $row["car_model"] . "</td>
                <td>" . $row["year"] . "</td>
                <td>" . $row["plate_id"] . "</td>
                <td> <img src='" . $row["image"] . "' alt='Car Image'> </td>
                <td>" . $row["rented_at"] . "</td>
                <td>" . $row["returned_at"] . "</td>
                <td>" . $row["rent_price"] . "</td>
                <td class='rent_status'>" . $row["rent_status"] . "</td>
                <td>
                <button class='return_car' onclick='returnCar(" . $row["id"] . ")'>Return</button>
                </td>
                <td>$priceToPay</td>
                
            </tr>";
            }
                echo "</table>"; // Closing the table
        }
    // Step 4: Close the connection
    $conn->close();
    ?>
    </div>
    <div class="container">
    <div id="carTable" class="table-section">
    <?php
    //////
    // Assuming you have a database connection established
    $conn = new mysqli('localhost', 'root', '', 'registration');
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    // Handle form data
    $idComparison = $_GET['idComparison'] ?? null;
    $id = $_GET['id'] ?? null;
    $model = $_GET['model'] ?? null;
    $yearComparison = $_GET['yearComparison'] ?? null;
    $year = $_GET['year'] ?? null;
    $priceComparison = $_GET['priceComparison'] ?? null;
    $price = $_GET['price'] ?? null;
    $status = $_GET['status'] ?? null; // Default to 'active' if not provided

    // Build your SQL query based on the form data
    $sql = "SELECT * FROM car WHERE status != 'deleted'";

    // Add conditions for other fields if they are not null
    if ($id != null) {
        $sql .= " AND car_id $idComparison '$id'";
    }
    if ($model != null) {
        $sql .= " AND car_model LIKE '%$model%'";
    }
    if ($year != null) {
        $sql .= " AND year $yearComparison '$year'";
    }

    if ($price != null) {
        $sql .= " AND price $priceComparison '$price'";
    }
    if ($status != null) {
        $sql .= " AND status = '$status'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Car Model</th><th>Year</th><th>Plate ID</th><th>Image</th><th>Price Hourly</th><th>Status</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
           // if($row['status'] != 'deleted'){
                $_SESSION['car_id'] = $row["car_id"];
                echo "<tr>
                <td>" . $row["car_id"] . "</td>
                <td>" . $row["car_model"] . "</td>
                <td>" . $row["year"] . "</td>
                <td>" . $row["plate_id"] . "</td>
                <td><img src='" . $row["image"] . "' alt='Car Image'></td>
                <td>" . $row["price"] . "</td> 
                <td class='car-status'>" . $row["status"] . "</td>
                <td>
                    <button class='rent' onclick='rentCar(" . $row["car_id"] . ")'>Rent</button>
                </td>
              </tr>";
           // }
            }
            echo "</table>"; // Closing the table
        }
    // Step 4: Close the connection
    $conn->close();
    ?>
    
    </div>

    <div class="form-section">
    <form id="form" action="customer.php" method="GET">
        <div class="form-group">
            <label for="id">Car ID:</label>
            <select id="idComparison" name="idComparison">
                <option value="=">Equal</option>
                <option value=">">Greater Than</option>
                <option value=">=">Greater Than or equal</option>
                <option value="<">Less Than</option>
                <option value="<=">Less Than or equal</option>
            </select>
            <input type="text" id="id" name="id">
        </div>

        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" id="model" name="model">
        </div>

        <div class="form-group">
            <label for="year">Year:</label>
            <select id="yearComparison" name="yearComparison">
                <option value="=">Equal</option>
                <option value=">">Greater Than</option>
                <option value=">=">Greater Than or equal</option>
                <option value="<">Less Than</option>
                <option value="<=">Less Than or equal</option>
            </select>
            <input type="text" id="year" name="year">
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <select id="priceComparison" name="priceComparison">
                <option value="=">Equal</option>
                <option value=">">Greater Than</option>
                <option value=">=">Greater Than or equal</option>
                <option value="<">Less Than</option>
                <option value="<=">Less Than or equal</option>  
            </select>
            <input type="text" id="price" name="price">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value=""></option>
                <option value="active">active</option>
                <option value="rented">rented</option>
                <option value="out_of_service">out_of_service</option>
            </select>
        </div>
        <button id="filter_button" type="submit">Search</button>
    </form>
    </div>  
    </div>
</body>

</html>
