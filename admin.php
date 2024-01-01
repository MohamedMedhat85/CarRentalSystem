
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        
        <link rel="stylesheet" href="current_cars.css">
        <link rel="stylesheet" href="admin.css">
        
        <script src="admin.js"></script>
        
    </head>

    <body>
        <?php
        // Start the session
        session_start();

        // Check if the user is logged in
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            // Redirect to the login page if not logged in
            header("Location: login.html");
            exit();
        }
        if ($_SESSION['role'] != 'admin') {
            // Redirect to a non-admin page or display an error message
            echo "You do not have permission to access this page.";
            exit();
        }
        if ($_SESSION['user_status'] == 'blocked') {
            // Redirect to a non-admin page or display an error message
            echo "You are blocked.";
            exit();
        }

        // Check if the user has the 'admin' role

        ?>
        <nav class="navbar1">
            <div class="navbar-section">
                <p>Car Rental System</p>
                <button id="car_button" onclick="toggleCarTable()">All Cars</button>
                <button onclick="toggleReservationsCar()">All Reservations</button>
                <button onclick="toggleUsersTable()">All Users</button> 
                <button onclick="toggleOfficeTable()">All Offices</button>
            </div>
            <div class="navbar-section">
                <p> <?php echo $_SESSION['email']; ?></p>
                <a href="http://localhost/FinalProject/logout.php">Logout</a>
            </div>
        </nav>
        <nav class="navbar2">
            <div class="navbar-section">
                <a href="http://localhost/FinalProject/add_car.html" >New Car</a>   
            </div>
            <div class="navbar-section">
                
                <a href="http://localhost/FinalProject/Registeration.html" >New Admin</a>
            </div>
        </nav>
        <div class="container">
        <div id="carTable" class="table-section">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'registration');
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        //
        $carIdComparison = $_GET['carIdComparison'] ?? null;
        $id = $_GET['id'] ?? null;
        $model = $_GET['model'] ?? null;
        $yearComparison = $_GET['yearComparison'] ?? null;
        $year = $_GET['year'] ?? null;
        $priceComparison = $_GET['priceComparison'] ?? null;
        $price = $_GET['price'] ?? null;
        $status = $_GET['status'] ?? null; // Default to 'active' if not provided
        $officeComparison = $_GET['officeIdComparison'] ?? null; 
        $officeID = $_GET['officeID'] ?? null; 
        $checkDate = $_GET['checkDate'] ?? null; 


        if($checkDate == null){
            $sql = "SELECT * FROM car WHERE 1=1";
    
            if ($id != null) {
                $sql .= " AND car_id $carIdComparison '$id'";
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
            if ($officeID != null) {
                $sql .= " AND office_id $officeComparison '$officeID'";
            }
            // 
        }
        else{
            $sql = "SELECT DISTINCT c.* 
                    FROM car as c 
                    JOIN reservations as r ON c.car_id = r.car_id 
                    WHERE DATE(r.rented_at) <= '" . $checkDate . "' AND DATE(r.returned_at) >= '" . $checkDate . "'";
            if ($id != null) {
                $sql .= " AND car_id $carIdComparison '$id'";
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
            if ($officeID != null) {
                $sql .= " AND office_id $officeComparison '$officeID'";
            }

        }
        $result = $conn->query($sql);  
        // Build your SQL query based on the form data
        $myArray = array(); 
        // Step 3: Fetch data and construct HTML table
        if ($result->num_rows > 0) {
            
            echo "<table border='1'><tr><th>ID</th><th>Car Model</th><th>Year</th><th>Plate ID</th><th>Image</th><th>Price Hourly</th><th>Status</th><th>Office ID </th><th>Actions </th></tr>";
            while ($row = $result->fetch_assoc()) {
                $_SESSION['car_id'] = $row["car_id"];
                
                if($checkDate == null){
                    echo "<tr>
                        <td>" . $row["car_id"] . "</td>
                        <td>" . $row["car_model"] . "</td>
                        <td>" . $row["year"] . "</td>
                        <td>" . $row["plate_id"] . "</td>   
                        <td><img src='" . $row["image"] . "' alt='Car Image'></td>
                        <td>" . $row["price"] . "</td>   
                        
                        <td class='car-status'>" . $row["status"] . "</td>
                        <td>" . $row["office_id"] . "</td>
                        <td>
                            <button class='edit-car' onclick='editCar(" . $row["car_id"] . ")'>Edit</button>
                            <button class='delete-car' onclick='deleteCar(" . $row["car_id"] . ")'>Delete</button>
                            <button class='activate-car' onclick='activateCar(" . $row["car_id"] . ")'>Activate</button>
                            <button class='deactivate-car' onclick='deactivateCar(" . $row["car_id"] . ")'>Deactivate</button>
                        </td>    
                    </tr>";
                    
                }
                else{
                    array_push($myArray, $row["car_id"]);
                    echo "<tr>
                    <td>" . $row["car_id"] . "</td>
                    <td>" . $row["car_model"] . "</td>
                    <td>" . $row["year"] . "</td>
                    <td>" . $row["plate_id"] . "</td>   
                    <td><img src='" . $row["image"] . "' alt='Car Image'></td>
                    <td>" . $row["price"] . "</td>   
                    <td class='car-status'>rented</td>
                    <td>" . $row["office_id"] . "</td>
                    <td>
                    </td>    
                    </tr>"; 
                }
                }
                

            }
            if($checkDate != null){
                $sql = "SELECT * FROM car WHERE car_id NOT IN (" . implode(',', $myArray) . ")";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>  
                        <td>" . $row["car_id"] . "</td>
                        <td>" . $row["car_model"] . "</td>
                        <td>" . $row["year"] . "</td>
                        <td>" . $row["plate_id"] . "</td>   
                        <td><img src='" . $row["image"] . "' alt='Car Image'></td>
                        <td>" . $row["price"] . "</td>   
                        <td class='car-status'>active</td>
                        <td>" . $row["office_id"] . "</td>
                        <td>
                        </td>    
                        </tr>"; 
                    }
                }
            }

            echo "</table>";
            ///////////
        // Step 4: Close the connection
        $conn->close();
        ?>
        </div>
            <div class="form-section">
        <form id="cars-form" action="admin.php" method="GET" >
        <div class="form-group">
                <label for="carIdComparison">Car ID:</label>
                <select id="carIdComparison" name="carIdComparison">
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
                <label for="yearComparison">Year:</label>
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
                <label for="priceComparison">Price:</label>
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
            <div class="form-group">
                <label for="officeIdComparison">Office ID:</label>
                <select id="officeIdComparison" name="officeIdComparison">
                    <option value=""></option>
                    <option value="=">Equal</option>
                    <option value=">">Greater Than</option>
                    <option value=">=">Greater Than or equal</option>
                    <option value="<">Less Than</option>
                    <option value="<=">Less Than or equal</option>  
                </select>
                <input type="number" id="officeID" name="officeID">
            </div>
            <div class="form-group">
                <label for="checkDate">Certain Day</label>
                <input type="date" id="checkDate" name="checkDate">
            </div>
            <button id="filter_button" type="submit">Search</button>
        </form>

        </div>  
        </div>


        <div class="container">
        <div id="userTable"  class="table-section">
            <?php
            $conn = new mysqli('localhost', 'root', '', 'registration');
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM user WHERE 1=1";
            //
            $userID = $_GET['userID'] ?? null;
            $email = $_GET['email'] ?? null;
            $name = $_GET['name'] ?? null;
            $role = $_GET['role'] ?? null;
            $user_status = $_GET['user_status'] ?? null;
        
            // Build your SQL query based on the form data
        
            // Add conditions for other fields if they are not null
            if ($userID != null) {
                $sql .= " AND user_id = '$userID'";
            }
        
            if ($email != null) {
                $sql .= " AND email LIKE '%$email%'";
            }
        
            if ($name != null) {
                $sql .= " AND name LIKE '%$name%'";
            }
        
            if ($role != null) {
                $sql .= " AND role = '$role'";
            }
            if ($user_status != null) {
                $sql .= " AND user_status = '$user_status'";
            }
            $sql .= " ORDER BY user_id asc";
            //
            $result = $conn->query($sql);

            // Step 3: Fetch data and construct HTML table
            if ($result->num_rows > 0) {
                echo "<table border='1'><tr><th>User ID</th><th>Email</th><th>Name</th><th>Password</th><th>Registeration Date</th><th>Role</th><th>User Status</th><th>Actions</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["user_id"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["password"] . "</td>   
                        <td>" . $row["registration_date"] . "</td> 
                        <td>" . $row["role"] . "</td>   
                        <td  class='user-status'>" . $row["user_status"] . "</td>  
                        <td>
                        <button class='block-button' onclick='blockUser(" . $row["user_id"] . ")'>Block</button>
                        <button class='activate-button' onclick='blockUser(" . $row["user_id"] . ")'>Activate</button>
                        </td>
                    </tr>";
                }
                echo "</table>";
                }
            // Step 4: Close the connection
            $conn->close();
            //////////////////////////////////////////12323123123/12/31/23/123/12/31/23/123/123
            ?>
        </div>
        <div class="form-section">
    <form id="users-form" action="admin.php" method="GET" >
        <div class="form-group">
            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value=""></option>
                <option value="admin">admin</option>
                <option value="customer">customer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_status">Status:</label>
                <select id="user_status" name="user_status">
                <option value=""></option>
                <option value="active">active</option>
                <option value="blocked">blocked</option>
            </select>
        </div>
        <button id="filter_button" type="submit">Search</button>
    </form>

    </div>  
        </div>
        <!-- #region
    
    
    -->
        <div class="container">
        <div id="myRentsTable" class="table-section">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'registration');
        // Check connection
        
        //
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM reservations JOIN car ON car.car_id = reservations.car_id WHERE 1=1";
        //
        $userIdComparison = $_GET['userIdComparison'] ?? null;
        $carId = $_GET['car_ID'] ?? null;
        $startDate = $_GET['startDate'] ?? null;
        $endDate = $_GET['endDate'] ?? null;
        $officeCompare = $_GET['officeIdCompare'] ?? null; 
        $officeId = $_GET['officeId'] ?? null; 
    
        // Build your SQL query based on the form data
    
        // Add conditions for other fields if they are not null
        if ($userIdComparison != null) {
            $sql .= " AND user_id = '$userIdComparison'";
        }
    
        if ($carId != null) {
            $sql .= " AND car.car_id = '$carId'";
        }
        
        if ($startDate != null) {
            $sql .= " AND rented_at > '$startDate'";
        }
    
        if ($endDate != null) {
            $sql .= " AND returned_at <  '$endDate'";
        }
        if ($officeId != null) {
            $sql .= " AND office_id  $officeCompare '$officeId'";
        }
        $sql .= " ORDER BY rented_at ASC";
        //
        $stmt = $conn->prepare($sql); 
        $user_id = $_SESSION['user_id'];/* Set the user ID here */ // Replace this with the actual user ID
        $stmt->execute();
        $result = $stmt->get_result();

        // Step 3: Fetch data and construct HTML table
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Reservation ID</th><th>user ID</th><th>Car ID</th><th>Car Model</th><th>Year</th><th>Plate ID</th><th>Image</th><th>Rented At</th><th>Returned At</th><th>Price Hourly</th><th>Office ID</th><th>Status</th><th>Actions</th><th>Price To Pay</th></tr>";

            while ($row = $result->fetch_assoc()) {
                date_default_timezone_set('Africa/Cairo');
                $_SESSION['car_id'] = $row["car_id"];
                $rentedAt = new DateTime($row["rented_at"]);
                $returnedAt = ($row["returned_at"] !== null) ? new DateTime($row["returned_at"]) : $currentDateTime = new DateTime(date('Y-m-d H:i:s'));

                $diff = $rentedAt->diff($returnedAt); 

                $diff->days.' Days total<br>'; 
                $diff->y.' Years<br>'; 
                $diff->m.' Months<br>'; 
                $diff->d.' Days<br>'; 
                $diff->h.' Hours<br>'; 
                $diff->i.' Minutes<br>'; 
        
                // Calculate the Price To Pay
                $total_minutes = ($diff->days * 24); 
                $total_minutes += ($diff->h);
                $total_minutes += $diff->i / 60; 
                $priceToPay = $total_minutes * $row["price"];
                $priceToPay = round($priceToPay, 2);    

                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["user_id"] . "</td>
                <td>" . $row["car_id"] . "</td>
                <td>" . $row["car_model"] . "</td>
                <td>" . $row["year"] . "</td>
                <td>" . $row["plate_id"] . "</td>
                <td><img src='" . $row["image"] . "' alt='Car Image'></td>
                <td>" . $row["rented_at"] . "</td>
                <td>" . $row["returned_at"] . "</td>
                <td>" . $row["rent_price"] . "</td>
                <td>" . $row["office_id"] . "</td>
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
        <div class="form-section">
    <form id="rents-form" action="admin.php" method="GET" >
        <div class="form-group">
            <label for="userIdComparison">User ID:</label>
            <input type="text" id="userIdComparison" name="userIdComparison">
        </div>

        <div class="form-group">
            <label for="car_ID">Car ID:</label>
            <input type="text" id="car_ID" name="car_ID">
        </div>
        <div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="datetime-local" id="startDate" name="startDate">
        </div>
        <div class="form-group">
            <label for="endDate">End Date</label>
            <input type="datetime-local" id="endDate" name="endDate">
        </div>
        <div class="form-group">
                <label for="officeIdCompare">Office ID:</label>
                <select id="officeIdCompare" name="officeIdCompare">
                    <option value=""></option>
                    <option value="=">Equal</option>
                    <option value=">">Greater Than</option>
                    <option value=">=">Greater Than or equal</option>
                    <option value="<">Less Than</option>
                    <option value="<=">Less Than or equal</option>  
                </select>
                <input type="text" id="officeId" name="officeId">
            </div>
        <button id="filter_button" type="submit">Search</button>
    </form>

    </div>  
    </div>
    <div class="container">
        <div id="office-table" class="table-section">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'registration');
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        //
        $officeIdComparison = $_GET['officeIdComparison'] ?? null;
        $officeId = $_GET['officeIDD'] ?? null;
        $officeName = $_GET['officeName'] ?? null;
        $officeLocation = $_GET['officeLocation'] ?? null;
        // Build your SQL query based on the form data
        $sql = "SELECT * FROM office WHERE 1=1";
    
        // Add conditions for other fields if they are not null
        if ($officeId != null) {
            $sql .= " AND office_id $officeIdComparison '$officeId'";
        }
    
        if ($officeName != null) {
            $sql .= " AND office_name LIKE '%$officeName%'";
        }
    
        if ($officeLocation != null) {
            $sql .= " AND location LIKE '%$officeLocation%'";
        }

        //
        $result = $conn->query($sql);

        // Step 3: Fetch data and construct HTML table
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Office ID</th><th>Office Name</th><th>Location</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["office_id"] . "</td>
                    <td>" . $row["office_name"] . "</td>
                    <td>" . $row["location"] . "</td>             
                </tr>";
            }
            echo "</table>";
            }
        // Step 4: Close the connection
        $conn->close();
        ?>
        </div>
            <div class="form-section">
        <form id="office-form" action="admin.php" method="GET" >
        <div class="form-group">
                <label for="officeIdComparison">Office ID:</label>
                <select id="officeIdComparison" name="officeIdComparison">
                    <option value="=">Equal</option>
                    <option value=">">Greater Than</option>
                    <option value=">=">Greater Than or equal</option>
                    <option value="<">Less Than</option>
                    <option value="<=">Less Than or equal</option>
                </select>
                <input type="number" id="officeIDD" name="officeIDD">
            </div>

            <div class="form-group">
                <label for="officeName">Name:</label>
                <input type="text" id="officeName" name="officeName">
            </div>

            <div class="form-group">
                <label for="officeLocation">Location:</label>
                <input type="text" id="officeLocation" name="officeLocation">
            </div>
            <button id="filter_button" type="submit">Search</button>
        </form>

        </div>  
        </div>

    </body>

    </html>
